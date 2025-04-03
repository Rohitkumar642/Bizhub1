<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProfileModel extends Model
{
    use HasFactory;

    protected $table = 'profiles'; // Table name
    public $timestamps = false; // Disable default timestamps

    protected $fillable = ['name', 'email','mobile','otp', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Store OTP
    public static function storeOtp($mobile, $otp)
    {
        return self::where('mobile', $mobile)->update(['otp' => $otp, 'updated_at' => now()]);
    }

    // Get stored OTP
    public static function getOtp($mobile)
    {
        return DB::table('profiles')
            ->where('mobile', $mobile)
            ->orderBy('created_at', 'DESC')
            ->first();
    }
}
