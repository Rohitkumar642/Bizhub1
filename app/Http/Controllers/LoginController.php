<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function show()
    {
        return view('login');
    }

    // Send OTP using TextLocal API
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $mobile = $request->mobile;
        
        // Check if the mobile number exists in the profile table
        $user = ProfileModel::where('mobile', $mobile)->first();
        
        if (!$user) {
            return response()->json(['status' => false, 'message' => "You don't have an account. Please sign up first."]);
        }
        
        // Generate 6-digit OTP
        $otp = random_int(100000, 999999);
        
        // Store OTP in the database
        if (!ProfileModel::storeOtp($mobile, $otp)) {
            return response()->json(['status' => false, 'message' => 'Failed to store OTP']);
        }
        
        // Prepare SMS message
        $msg = "$otp is your Antworks Account verification code - ANTWORKS";
        $message = rawurlencode($msg);
        
        // Send OTP via API
        $response = Http::asForm()->post('https://api.textlocal.in/send/', [
            'username' => env('SMS_GATEWAY_USERNAME'),
            'hash' => env('SMS_GATEWAY_HASH_API'),
            'numbers' => $mobile,
            'sender' => env('SMS_GATEWAY_SENDER'),
            'message' => $message,
        ]);
        
        $responseData = $response->json();
        
        if (isset($responseData['status']) && $responseData['status'] == "success") {
            return response()->json(['status' => true, 'message' => 'OTP sent successfully!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to send OTP', 'error' => $responseData]);
        }
    }

    // Verify OTP
    public function verifyOtpmobile(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6'
        ]);

        $mobile = $request->mobile;
        $otp = $request->otp;

        // Retrieve stored OTP
        $otpRecord = ProfileModel::getOtp($mobile);

        if ($otpRecord && $otpRecord->otp == $otp) {

            Session::put('vendor_email', $otpRecord->email);
            return response()->json(['status' => true, 'message' => 'OTP verified successfully!', 'redirect' => route('home')]);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid OTP']);
        }
    }

    public function logout(Request $request)
    {
        session()->flush(); // Clear session
        return redirect()->route('login')->with('error', 'You have been logged out.');
    }
}
