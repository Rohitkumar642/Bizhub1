<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HomeModel extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'legal_name',
        'gst_no',
        'vendor_email',
        'registration',
        'duty',
        'company_type',
        'status',
        'trade_name',
        'nature_business',
        'address',
        'district',
        'state',
        'pin_code'
    ];
}
