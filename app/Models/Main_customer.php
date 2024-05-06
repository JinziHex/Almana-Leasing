<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Main_customer extends Authenticatable
{
	 use  Notifiable;
    protected $table="main_customers";
    protected $guard = 'main_customer';

    protected $fillable =['id','customer_id','cust_mobile','email','password','profile_status','otp_verify','created_at','updated_at'];

   public function customer()
   {
   	return $this->belongsTo('App\Models\Customer','customer_id','customer_id');
   }

   protected $hidden = [
        'password',
    ];
}
