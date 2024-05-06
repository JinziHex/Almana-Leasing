<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp_verify extends Model
{
    protected  $primaryKey = "otp_id";
    protected 	$fillable=['otp_id','cust_id','otp','expiry','created_at','updated_at'];
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $casts = [
    'expiry' => 'datetime:Y-m-d H:i:s',
    ];
}
