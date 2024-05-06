<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Main_customer;
use Auth;
use Hash;
use Carbon;
use Validator;

class ProfileController extends Controller
{

    public function user_info_update(Request $request, Customer $customer)
    {
        $data=array();
        try
        {

            $custId = $request->input('customer_id');
            $customer = Customer::Find($custId);

            // $validator = Validator::make($request->all(), [      
            //     'cust_fname' => 'required',
            //     'cust_lname' => 'required',
            //     'cust_dob' => 'required|date',
            //     'cust_driving_license_no' => 'required',
            //     'cust_license_issued_country' =>'required',
            //     'cust_license_issued_date' => 'required',
                
                

            // ]);

            // if(!$validator->fails())
            //     {
                    if($request->email)
                    {
                        Main_customer::where('customer_id','=',$custId)->update([
                            'email' =>$request->email
                        ]);
                    }
                    
                    $cont = $request->cust_license_issued_country;
                    $customer->cust_fname = $request->cust_fname;
                    $customer->cust_lname = $request->cust_lname;
                    $customer->email = $request->email;
                    $customer->cust_mobile_number = $request->cust_mobile_number;
                    $customer->cust_dob = $request->cust_dob;
                    $customer->cust_address_line_1 = $request->billing_address_line_1;
                    $customer->cust_address_line_2 = $request->billing_address_line_2;
                    $customer->cust_nationality = $request->cust_nationality;
                    $customer->cust_bill_country = $request->billing_country;
                    $customer->cust_city = $request->billing_city_id;
                    $customer->cust_state = $request->billing_location_id;
                    $customer->cust_driving_license_no = $request->cust_driving_license_no;
                    $customer->cust_license_issued_country = $request->cust_license_issued_country;
                    $customer->cust_license_issued_date = $request->cust_license_issued_date;
                    $customer->save();
                    $data['status'] = 1 ;
                    $data[ 'message' ] = "Profile Updated";
                    return response($data);

            // }else{
            //         $data['errors'] = $validator->errors();
            //         $data['message'] = "Profile Updation Failed";
            //     }

       }catch (\Exception $e) {
            $response = ['status' => '0', 'message' => $e->getMessage()];
            return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];
            return response($response);
        }   
    }

    public function password_change(Request $request)
    {
        $data=array();
        try
        {
            $custmrId = $request->input('customer_id');
            $fetchCustDet = Main_customer::where('customer_id','=',$custmrId)->first();
            // $userid = Auth::guard('api')->user()->customer_id;
            // dd(Hash::check(request('old_password'), $fetchCustDet->password));
            $validator = Validator::make($request->all(), [      
                'old_password' => 'required',
                'new_password' => 'required|min:8',  
            ],
            [   
                'old_password.required' => "Old password field cannot be empty", 
                'new_password.required' => "New password field is required"
            ]);
             if(!$validator->fails())
                {
            if ((Hash::check(request('old_password'), $fetchCustDet->password)) == false) {
                $data['status'] ="0";
                $data['message'] = "Current password is incorrect.";
                } else if ((Hash::check(request('new_password'), $fetchCustDet->password)) == true) {
                    $data['status'] ="0";
                    $data['message'] = "Please enter a password which is not similar then current password.";
                   
                } else {
                    $encPass = Hash::make($request->input('new_password'));
                    Customer::where('customer_id', $custmrId)->update(['cust_password' => $encPass]);
                    Main_customer::where('customer_id', $custmrId)->update(['password' => $encPass]);
                    $data['status'] ="1";
                    $data['message'] = "Password Change successfully";
                }
                }else{
                    $data['status'] = "0";
                    $data['errors'] = $validator->errors(); 
                }
                return response($data);

        }catch (\Exception $e) {
                $response = ['status' => '0', 'message' => $e->getMessage()];
                return response($response);
            }catch (\Throwable $e) {
                $response = ['status' => '0','message' => $e->getMessage()];
                return response($response);
            } 
    } 

    public function logoutApi()
    { 
        $data=array();
        try
        {
            if (Auth::check()) {
                // $user = Auth::user();
                // dd($user);
               Auth::user()->AauthAcessToken()->delete();
                $data['status'] = "1";
                $data['message'] = "User Logged Out"; 
                
            }else{
                $data['status'] = "0";
                $data['message'] = "No customer Exist";
            }
            return response($data);

        }catch (\Exception $e) {
                $response = ['status' => 'false', 'message' => $e->getMessage()];
                return response($response);
            }catch (\Throwable $e) {
                $response = ['status' => 'false','message' => $e->getMessage()];
                return response($response);
            } 
    }

    
    public function getUpdateInfo(Request $request, Customer $customer)
    {
        $data=array();
        try
        {

            $custId = $request->input('customer_id');
            $customer = Customer::Find($custId);

            $validator = Validator::make($request->all(), [      
                'customer_id' => 'required'

            ]);

            if(!$validator->fails())
                {
                    $data['Status'] = 1 ;
                    $data['First_name'] = $customer->cust_fname;
                    $data['Last_name'] = $customer->cust_lname;
                    $data['Email_Address'] = $customer->email;
                    $data['Mobile_code'] = $customer->cust_mobile_code;
                    $data['Mobile_number'] = $customer->cust_mobile_number;
                    $data['Date_of_birth'] = $customer->cust_dob;
                    $data['Nationality_id'] = $customer->cust_nationality;
                    $data['Nationality'] = @$customer->nationality['country_name'];
                    $data['Driving_License_No'] = $customer->cust_driving_license_no;
                    $data['License_Issued_Country'] = $customer->cust_license_issued_country;
                    $data['License_Issued_Country_Name'] = @$customer->countryname['country_name'];
                    $data['Issue_date'] = $customer->cust_license_issued_date;
                    $data['Billing_Address_Line_1'] = $customer->cust_address_line_1;
                    $data['Billing_Address_Line_2'] = $customer->cust_address_line_2;
                    $data['Billing_country_id'] = $customer->cust_bill_country;
                    $data['Billing_country'] = @$customer->billcountry['country_name'];
                    $data['Billing_city_id'] = $customer->cust_city;
                    $data['Billing_city'] = @$customer->custCity['city_name'];
                    $data['Billing_city_Arb'] = @$customer->custCity['ar_city_name'];
                    $data['Billing_location_id'] = $customer->cust_state;
                    $data['Billing_location'] = @$customer->location['location_name'];
                    $data['Billing_location_Arb'] = @$customer->location['ar_location_name'];
                    return response($data);

            }else{
                    $data['errors'] = $validator->errors();
                    $data['message'] = "No Customer exist";
                }

       }catch (\Exception $e) {
            $response = ['status' => '0', 'message' => $e->getMessage()];
            return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];
            return response($response);
        }   
    }
    
    
    public function Customerdeactivate()
    { 
        $data=array();
        try
        {
            if (Auth::check()) {
                $user = Auth::user();
                Customer::where('customer_id','=',$user->customer_id)->update([
                    'cust_profile_status' => 0
                    ]);
                Main_customer::where('customer_id','=',$user->customer_id)->update([
                    'profile_status' => 0
                    ]);
               
                $data['status'] = 1;
                $data['message'] = "Your account does not exist or has been deactivated."; 
                
            }else{
                $data['status'] = 0;
                $data['message'] = "No customer Exist";
            }
            return response($data);

        }catch (\Exception $e) {
                $response = ['status' => 'false', 'message' => $e->getMessage()];
                return response($response);
            }catch (\Throwable $e) {
                $response = ['status' => 'false','message' => $e->getMessage()];
                return response($response);
            } 
    }
    
}
