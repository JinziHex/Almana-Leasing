<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Country;
use App\Models\City;
use App\Models\Currency;
use App\Models\City_location;
use Carbon;
use Crypt;
use App\Models\Customer;
use App\Models\Otp_verify;
use App\Models\Main_customer;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

	 public function showRegistrationForm()
    {
        $fetchCont = Country::orderBy('country_id','DESC')->get();
        return view('front-end.elements.user.register',compact('fetchCont'));
    }

    public function getUserProfile(Request $request)
    {
        if(Auth::guard('main_customer')->check())
        {
            $pageTitle = "User Profile";
            $getCont = Country::orderBy('country_name','ASC')->get();
            $fetchCity = City::orderBy('city_id','DESC')->get();
            $fetchCust = Main_Customer::where('customer_id','=',Auth::guard('main_customer')->user()->customer_id)->first();
            
            return view('front-end.elements.user.profile',compact('fetchCust','pageTitle','getCont','fetchCity'));
        }else{
            return redirect('/');
        }
    }

    public function userProfileUpdate(Request $request, Customer $customer)
    {
        if($request->cust_license_issued_date){
            $request->validate(
                [
                  'cust_license_issued_date' => ['date_format:Y-m-d', 'after_or_equal:now']
                ],
                [
                  'cust_license_issued_date.after_or_equal' => "THE CUSTOMER LICENCE EXPIRY DATE MUST BE GREATER THAN TODAY"
                ]
            );
        }
          
        if(Auth::guard('main_customer')->check())
        {
            $cont = $request->cust_license_issued_country;
            $curId = $request->customer_id;
            $customer = Customer::Find($curId);
            $customer->cust_fname = $request->cust_fname;
            $customer->cust_lname = $request->cust_lname;
            $customer->email = $request->email;
            $customer->cust_mobile_number = $request->cust_mobile_number;
            $customer->cust_dob = $request->cust_dob;
            $customer->cust_address_line_1 = $request->cust_address_line_1;
            $customer->cust_address_line_2 = $request->cust_address_line_2;
            $customer->cust_nationality = $request->cust_nationality;
            $customer->cust_bill_country = $request->cust_bill_country;
            $customer->cust_city = $request->cust_city;
            $customer->cust_state = $request->cust_state;
            $customer->cust_driving_license_no = $request->cust_driving_license_no;
            $customer->cust_license_issued_country = $cont;
            $customer->cust_license_issued_date = $request->cust_license_issued_date;
            $customer->save();
            if($request->filled('email'))
            {
                Main_Customer::where('customer_id','=',$curId)->update([
                    'email' => $request->email,

                ]);
            }
            return back()->with('status','Saved Profile Information');


        }else{
            return redirect('/');
        }
    }

    public function userChangePassword()
    {
        if (Auth::guard('main_customer')->check()) {
            $pageTitle = "Change Password";
            $custId = Auth::guard('main_customer')->user()->customer_id;
            return view('front-end.elements.user.change-password',compact('custId','pageTitle'));
        }else{
            return redirect('/');
        }
    }

    public function userUpdatePassword(Request $request)
    {
        if(Auth::guard('main_customer')->check())
        {
            $custmrId = $request->customer_id;
            $curNtPassword = $request->current_password;
            $checkPass = Main_Customer::where('customer_id','=',$custmrId)->first();
            $getOLdPass = $checkPass->password;
            $newPass = $request->password;
            
             $validator = Validator::make($request->all(), [   
            
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
            ]);
            if(!$validator->fails())
            {
                if (Hash::check($curNtPassword,$getOLdPass)) //if current password and old pass is equal
                    {
                
                    if (!Hash::check($newPass,$getOLdPass)) //if both password are not same then update
                        {
                            $hashdPass =  Hash::make($request->input('password'));
                           Main_customer::where('customer_id','=',$custmrId)->update([
                            'password' => $hashdPass
                            ]);
                           Customer::where('customer_id','=',$custmrId)->update([
                            'cust_password' => $hashdPass
                            ]);
                            $request->session()->invalidate();

                                $request->session()->regenerateToken();
                                return redirect('user-login')->with('status','Please login again');
                }else{
                    return redirect()->back()->with('status-error','Your new password cannot be same as your current password');
                } 
                }else{
                    return redirect()->back()->with('status-error','Invalid Current password ');
                } 
                
            }else{
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

                

        }else{
            return redirect('/');
        }
    }
}
