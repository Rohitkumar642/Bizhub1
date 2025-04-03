<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\HomeModel;
use App\Models\Vendor;

class HomeController extends Controller
{
    public function index(Request $request)
{
    // Retrieve vendor email from session
    $vendorEmail = Session::get('vendor_email');

    if (!$vendorEmail) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    // Fetch vendors based on session email
    $vendors = HomeModel::where('vendor_email', $vendorEmail)->get();

    return view('user.home', compact('vendors'));
}


    public function updateVendor(Request $request)
    {
        $request->validate([
            'vendor_email' => 'required|email',
            'gst_no' => 'required|string',
            'legal_name' => 'required|string',
            'duty' => 'required|string',
            'registration' => 'required|string',
            'company_type' => 'required|string',
            'status' => 'required|string',
            'trade_name' => 'required|string',
            'nature_business' => 'required|string',
            'address' => 'required|string',
            'district' => 'required|string',
            'state' => 'required|string',
            'pin_code' => 'required|numeric',
        ]);

        $vendor = Vendor::where('vendor_email', $request->vendor_email)->first();

        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found'], 404);
        }

        // Update vendor details
        $vendor->update($request->all());

        return response()->json(['message' => 'Vendor updated successfully']);
    }

    public function inquiry(){

        return view('user.enquiry');
    }

    public function subscribe(){

        return view('user.subscribe');
    }

    public function unsubscribe(){

        return view('user.unsubscribe');
    }

    public function edit(Request $request){

        $vendorEmail = $request->query('vendor_email');

        $vendors = HomeModel::where('vendor_email', $vendorEmail)->get();

        return view('user.edit', compact('vendors'));
    }
}
