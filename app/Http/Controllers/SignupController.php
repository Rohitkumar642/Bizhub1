<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\ProfileModel;

class SignupController extends Controller
{
    public function signup(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email',
            'mobile' => 'required|digits:10'
        ]);

        // Check if the mobile number already exists in the database
        $existingUser = ProfileModel::where('mobile', $request->mobile)->first();

        if ($existingUser) {
            return response()->json(['status' => false, 'message' => 'You already have an account with this Mobile. Please login.']);
        }

        // Generate a 6-digit random OTP
        $otp = rand(100000, 999999);

        // Store new user in the database
        ProfileModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'otp' => $otp,
            'created_at' => now()
        ]);

        $mobile = $request->mobile;

        $msg = "$otp is your Antworks Account verification code - ANTWORKS";
        $message = rawurlencode($msg);

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

    public function checkotp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6'
        ]);

        $profile = ProfileModel::where('mobile', $request->mobile)->where('otp', $request->otp)->first();

        if ($profile) {
            return response()->json(['status' => true, 'message' => 'OTP Verified! Redirecting...']);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid OTP.']);
        }
    }
}
