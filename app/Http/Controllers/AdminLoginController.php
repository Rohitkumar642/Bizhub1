<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileModel;
use App\Models\Vendor;
use App\Models\Subscriber;
use App\Models\Inquiry;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Fetch admin from the database
        $admin = Admin::where('email', $request->email)->first();

        // Check credentials
        if ($admin && $admin->password === $request->password) {
            // Store session with last activity timestamp
            session([
                'admin_logged_in' => true,
                'admin_email' => $request->email,
                'last_activity' => now()
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Login successful');
        } else {
            return back()->with('error', 'Invalid credentials');
        }
    }

    public function dashboard(Request $request)
    {
        // Check if session exists and user is logged in
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Session expired. Please log in again.');
        }

        // Auto logout after 15 minutes of inactivity
        $lastActivity = session('last_activity');
        if ($lastActivity && now()->diffInMinutes($lastActivity) > 15) {
            return $this->logout($request);
        }

        // Update last activity timestamp
        session(['last_activity' => now()]);

        $totalUser = ProfileModel::count();
        $totalVendors = Vendor::count();
        $totalSubscribers = Subscriber::where('status', 'subscribed')->count();
        $totalUnSubscribers = Subscriber::where('status', 'unsubscribed')->count();
        $totalEnquiries = Inquiry::count();

        return view('admin.dashboard', compact('totalUser','totalVendors','totalSubscribers', 'totalUnSubscribers', 'totalEnquiries'));
    }

    public function logout(Request $request)
    {
        session()->flush(); // Clear session
        return redirect()->route('admin.login')->with('error', 'You have been logged out due to inactivity.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $admin = DB::table('admins')->where('email', $email)->first();

        if (!$admin) {
            return response()->json(['message' => 'Email not registered as admin'], 404);
        }

        // Generate a random password
        $randomPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
        //$hashedPassword = Hash::make($randomPassword);

        // Update password in the database
        DB::table('admins')->where('email', $email)->update(['password' => $randomPassword]);

        // Send new password via email
        Mail::raw("Your new password is: $randomPassword", function ($message) use ($email) {
            $message->to($email)->subject('Admin Password Reset');
        });

        return response()->json(['message' => 'A new password has been sent to your email'], 200);
    }
}
