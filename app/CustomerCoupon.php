<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCoupon extends Model
{
    public function coupon()
    {
       return $this->hasOne('App\Coupon','id','coupon_id');
    }
}
