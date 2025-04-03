<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'gst_no',
        'vendor_email',
        'legal_name',
        'duty',
        'registration',
        'company_type',
        'status',
        'trade_name',
        'nature_business',
        'address',
        'district',
        'state',
        'pin_code',
        'otp'
    ];
}

