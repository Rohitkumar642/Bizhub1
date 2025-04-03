<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Mail\VendorOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VendorController extends Controller
{
    public function show()
    {
        return view('vendor');
    }

    public function fetchVendorData(Request $request)
    {
        $gstNo = $request->input('gst_no');
        $vendorEmail = $request->input('vendor_email');
        $providedVendorName = trim(strtolower($request->input('vendor_name')));

        $existingVendor = Vendor::where('gst_no', $gstNo)->first();

        if ($existingVendor) {
            $createdDate = strtotime($existingVendor->created_at);
            $currentDate = time();
            $daysDiff = floor(($currentDate - $createdDate) / (60 * 60 * 24));

            if ($daysDiff <= 90 && strtolower($existingVendor->legal_name) !== $providedVendorName) {
                return response()->json(['status' => false, 'message' => 'Vendor Name does not match the registered legal name!']);
            }

            return response()->json(['status' => true, 'data' => $existingVendor]);
        }

        $apiKey = 'bd380b0386e0a911130553e6ff5b8fb4';
        $apiUrl = "http://sheet.gstincheck.co.in/check/$apiKey/$gstNo";
        $apiResponse = Http::get($apiUrl);
        $gstData = $apiResponse->json();

        if (!$gstData || isset($gstData['errorMsg']) || !isset($gstData['data']['lgnm'])) {
            return response()->json(['status' => false, 'message' => 'Invalid GST Number or API Error']);
        }

        $fetchedLegalName = trim(strtolower($gstData['data']['lgnm']));
        if ($providedVendorName !== $fetchedLegalName) {
            return response()->json(['status' => false, 'message' => 'Vendor Name does not match the GST legal name!']);
        }

        $data = [
            'vendor_email' => $vendorEmail,
            'legal_name' => $gstData['data']['lgnm'],
            'state' => $gstData['data']['pradr']['addr']['stcd'],
            'duty' => $gstData['data']['dty'],
            'gst_no' => $gstData['data']['gstin'],
            'registration' => $gstData['data']['rgdt'],
            'company_type' => $gstData['data']['ctb'],
            'status' => $gstData['data']['sts'],
            'trade_name' => $gstData['data']['tradeNam'],
            'nature_business' => is_array($gstData['data']['nba']) ? implode(', ', $gstData['data']['nba']) : $gstData['data']['nba'],
            'address' => $gstData['data']['pradr']['adr'],
            'district' => $gstData['data']['pradr']['addr']['dst'],
            'pin_code' => $gstData['data']['pradr']['addr']['pncd'],
        ];
        //$registration = Carbon::createFromFormat('d/m/Y', $request->registration)->format('Y-m-d');

        Vendor::updateOrCreate(['gst_no' => $gstNo], $data);
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function registerVendor(Request $request)
    {
        $vendorEmail = $request->input('vendor_email');
        $vendor = Vendor::where('vendor_email', $vendorEmail)->first();

        if (!$vendor) {
            return response()->json(['status' => false, 'message' => 'Vendor not found.']);
        }

        if ($vendor->status !== 'active') {
            return response()->json(['status' => false, 'message' => 'Status is Inactive. Please contact help desk.']);
        }

        $otp = rand(100000, 999999);
        $vendor->update(['otp' => $otp]);

        try {
            Mail::to($vendorEmail)->send(new VendorOtpMail($otp));
            return response()->json(['status' => true, 'message' => 'OTP sent to your email.', 'email' => $vendorEmail]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to send OTP. Error: ' . $e->getMessage()]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'vendor_email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $vendor = Vendor::where('vendor_email', $request->vendor_email)->first();

        if (!$vendor) {
            return response()->json(['status' => false, 'message' => 'Vendor not found.']);
        }

        if ($vendor->otp == $request->otp) {
            // Clear OTP after successful verification
            //$vendor->update(['otp' => null]);

            Session::put('vendor_email', $request->vendor_email);

            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully!',
                'redirect' => route('home') // Redirect to home page
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid OTP.']);
        }
    } 



    public function registerVendorNoGst(Request $request)
    {
        $data = $request->only([
            'legal_name', 'vendor_email', 'duty', 'registration', 'company_type', 'status',
            'trade_name', 'nature_business', 'address', 'district', 'state', 'pin_code'
        ]);

        if ($data['status'] !== 'Active') {
            return response()->json(['status' => false, 'message' => 'Status is Inactive. Please contact help desk.']);
        }

        Vendor::create($data);

        Session::put('vendor_email', $request->vendor_email);

        return response()->json([
            'status' => true, 
            'message' => 'Vendor registered successfully.', 
            'redirect' => route('home') 
        ]);
    }
}