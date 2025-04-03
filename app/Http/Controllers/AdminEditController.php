<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AdminEditController extends Controller
{
    public function editProfile()
    {
        // Check if the admin is logged in via session
        if (!session()->has('admin_email')) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized access.');
        }

        // Fetch the admin user from the database using email
        $admin = Admin::where('email', session('admin_email'))->first();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Admin not found.');
        }

        return view('admin.edit-profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        // Ensure the user is logged in
        if (!session()->has('admin_email')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Get the admin user from session (using email)
        $admin = Admin::where('email', session('admin_email'))->first();

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        // Validate request data
        $request->validate([
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:6',
        ]);

        // Update email
        $admin->email = $request->email;

        // Update password if provided
        if (!empty($request->password)) {
            $admin->password = $request->password; // Hash the password
        }

        $admin->save();

        // Update session with new email
        session(['admin_email' => $admin->email]);

        return response()->json(['message' => 'Profile updated successfully']);
    }
}
