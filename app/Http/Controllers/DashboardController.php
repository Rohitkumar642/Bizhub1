<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Subscriber;
use App\Models\Inquiry;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    

    public function vendorList()
    {
        return view('admin.vendors');
    }

    public function getVendors(Request $request)
    {
        $vendors = Vendor::select(['id', 'gst_no', 'vendor_email', 'legal_name', 'duty','registration','company_type','status','trade_name','nature_business','address','district','state','pin_code']);
        return DataTables::of($vendors)->editColumn('gst_no', function ($vendor) { return $vendor->gst_no ?? 'N/A';})->make(true);
        
    }

    public function showSubscribers()
    {
        $users = Subscriber::where('status', 'subscribed')->get(); // Fetch all users
        return view('admin.subscriber', compact('users'));
    } 
    
    public function UnSubscribers()
    {
        $users = Subscriber::where('status', 'unsubscribed')->get(); // Fetch all users
        return view('admin.unsubscriber', compact('users'));
    } 

    public function Inquiries()
    {
        $users = Inquiry::all(); // Fetch all users
        return view('admin.inquiry', compact('users'));
    } 
}