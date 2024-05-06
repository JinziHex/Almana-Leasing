<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Forgot_password_otp extends Model
{
    protected $table="forgot_password_otps";

    protected $primaryKey = "f_otp_id";

    protected $fillable=['f_otp_id','customer_id','f_otp','expiry','created_at','updated_at'];
    
    protected $casts = [
    'expiry' => 'datetime:Y-m-d H:i:s',
    ];
}
