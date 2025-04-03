<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Models\Admin;
use App\Mail\InquiryMail;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'message' => 'required|string',
        ]);

        Inquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        Mail::to($request->email)->send(new InquiryMail($request->all()));

        $adminEmail = Admin::pluck('email')->first();

        if($adminEmail){
            Mail::to($adminEmail)->send(new InquiryMail($request->all()));
        }

        return response()->json(['message' => 'Inquiry submitted successfully!']);
    }
}

