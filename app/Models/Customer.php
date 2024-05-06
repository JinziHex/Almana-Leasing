<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
	use HasApiTokens;
	
    protected $primaryKey = 'customer_id';

    protected $fillable=['customer_id','cust_code','cust_fname','cust_lname','cust_mobile_code','cust_mobile_number','cust_license_issued_country','email','cust_password','cust_dob','cust_qatar_id','cust_passport_number','cust_nationality','cust_city','cust_state','cust_zipcode','cust_profile_status','cust_otp_verify','cust_address_line_1','cust_address_line_2','cust_bill_country','api_token','created_at','updated_at'];
    
     public function AauthAcessToken()
    {
    	return $this->hasMany('\App\Models\OauthAccessToken','user_id','customer_id');
	}
	
	public function countryname()
    {
    	 return $this->belongsTo('App\Models\Country','cust_license_issued_country','country_id');
    }
    public function nationality()
    {
         return $this->belongsTo('App\Models\Country','cust_nationality','country_id');
    }
    public function location()
    {
         return $this->belongsTo('App\Models\City_location','cust_state','city_loc_id');
    }
    public function custCity()
    {
         return $this->belongsTo('App\Models\City','cust_city','city_id');
    }
    
    public function billcountry()
    {
        return $this->belongsTo('App\Models\Country','cust_bill_country','country_id');
    }
    
    public function licenseCountry()
    {
        return $this->belongsTo('App\Models\Country','cust_license_issued_country','country_id');
    }

}
