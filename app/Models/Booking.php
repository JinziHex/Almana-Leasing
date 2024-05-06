<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'book_id';
    protected $fillable=['book_id','book_ref_id','book_from_date','book_to_date','book_car_model','coupon_discount','book_car_rate_type','book_daily_rate','book_total_rate','book_pickup_time','book_return_time','book_cust_id','book_bill_cust_fname','book_bill_cust_lname','book_bill_cust_mobile_code','book_bill_cust_mobile','book_bill_cust_qatar_id','book_bill_cust_nationality','book_bill_cust_address_1','book_bill_cust_address_2','book_bill_cust_city','book_bill_cust_state','book_bill_cust_zipcode','book_bill_cust_location','cust_dob','cust_passport','payment_status','drop_fee','additional_package','active_flag','book_status','book_file','payment_session_id ','created_at','updated_at'];

    public function country()
    {
    	return $this->belongsTo('App\Models\Country','book_bill_cust_nationality','country_id');
    }
    
     public function city()
    {
    	return $this->belongsTo('App\Models\City','book_bill_cust_city','city_id');
    }

    public function state()
    {
    	return $this->belongsTo('App\Models\City_location','book_bill_cust_location','city_loc_id');
    }
    
     public function model()
    {
    	return $this->belongsTo('App\Models\Modal','book_car_model','modal_id');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer','book_cust_id','customer_id');
    }
      public function rates()
    {
        return $this->belongsTo('App\Models\Rate_type','book_car_rate_type','rate_type_code');
    }
    public function status()
    {
        return $this->belongsTo('App\Models\Status','book_status','status_id');
    }
    public function paymentStatus()
    {
        return $this->belongsTo('App\Models\Payment_status','payment_status','payment_id');
    }

    protected $casts = [
    'book_pickup_time' => 'datetime:H:i:s',
    'book_return_time' => 'datetime:H:i:s',
    ];
}
