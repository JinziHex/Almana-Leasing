<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Otp_verify;
use App\Models\Main_customer;
use App\Models\Device;
use App\Models\Currency;
use App\Models\Country;
use Crypt;
use Auth;
use Hash;
use Carbon;
use Validator;
use BulkGate;

class CustomerController extends Controller
{
    
    public function testsms()
    {
        $otp = "9090";
        $mergCodeMob ="917559854605";
        $curl=curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw1057&password=v7ute6lw&content=OTP+is+'.$otp.'+signup+to+Almana+Leasing+,+Thank+you&destination='.$mergCodeMob.'&source=97197&mask=AL%20Mana',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                ));

           $response = curl_exec($curl);
           dd($response);

            curl_close($curl);
    }
    public function testreserve()
    {
        $client = new \GuzzleHttp\Client();
                        $api2 =   $client->post('http://130.61.97.192:201/Reservation',
                        array(
                            'form_params' => 
                            array(
                               
                              "rsr_book_date"=>"2022-11-30",  

                            
                              "rsr_cust_name"=>"John Doe", 
                              
                              "rsr_cust_cat_code"=>"test", 
                               "rsr_cust_code"=>"test100", 
                              
                              "rsr_cust_gender"=>"MALE",
                            
                              "rsr_cust_addr"=>"sadfaghdghasd",  
                              'rsr_cust_dob'=>"1998-10-26",
                              
                              "rsr_cust_cat_code "=>"GAH",
                              
                              'rsr_customer_passport'=>'test-passport',
                              
                              'rsr_customer_passport_exp'=>"2022-11-07",
                              
                              'rsr_rent_start_date'=>'2022-11-08',
                              
                              'rsr_rent_start_time'=>'12:30',
                              
                              'rsr_rent_end_date'=>'2022-11-10',
                              
                              'rsr_rent_end_time'=>'12:30',
                              
                              'rsr_cust_qid'=>'test-qid',
                              
                              'rsr_cust_qid_exp'=>"2022-11-07",
                              
                              'rsr_rental_days'=>"2",
                              
                              'rsr_rental_amount'=>"2000",
                              
                              'rsr_pickup_location'=>"Doha",
                            
                              "rsr_tel"=>1,          
                            
                              "rsr_email"=>1,        
                            
                              "rsr_nation"=>1,      
                            
                              "rsr_cust_id"=>19789,
                              
                              "rsr_cust_id_exp"=>"2022-10-29",
                              
                             
                              
                              "rsr_driving_lic_no"=>19789,
                              
                              "rsr_driving_lic_exp"=>"2023-10-05",
                              
                              "rsr_coupon_code"=>'test',
                              
                              "rsr_coupon_disc"=>5,
                              
                              "rsr_act_flag"=>'A',
                            
                              "rsr_rent_date"=>"2022-10-31",    
                            
                              "rsr_rent_time"=>"11:30",    
                            
                              "rsr_car_group"=>1,    
                            
                              "rsr_car_make"=>1,    
                            
                              "rsr_car_model"=>1,    
                            
                              "rsr_rent_type"=>1,   
                            
                              "rsr_rent_rate"=>1,  
                              
                              'rsr_cust_category'=>1,
                            
                              "rsr_website_booking_ref"=>"1000ADDHSGDS"
                            )
                        )
                    );
                    $data2 = $api2->getBody()->getContents();
                    $response2 = json_decode($data2, true);
                    return response($response2);
    }
    public function testPayment(Request $request)
    {
        $skipCashKeyId="e0c81353-ed49-4203-8724-313126b21681";
         $skipCashClientId="00d89469-0d43-4b41-8643-5d12fa46b6bf";
         $skipCashSecretKey="56NdvKtI6YTDZl9F3LbK4S3HmTL/K3ZpsM7ay7s28ON30haLo3t/nYm+6go4WCcXKn0/Krb4mVEnYoIa2jZv21CV9n1u6M6qmQX97cG1IEOLZCHenLZLXmk2bZoYza9Fli7ZZjiiyCfRgR+KZGgCzgU/sK1yRMqc9MaTTy5xw6pisLv+VwsW/0nKVhiMOY0qBSKFYaXvhb08ruQrn4rn4GnhKmR5rxYV/CudiqTeXmkKLQO8od2Q/zcRqr+T2e5gXLG8v7sI1wOspcvIadZGRiAJOEievXTXnSekteoLjibtGpsHcDRnARpWTBJQvUSLu6x0aOP7IuzMM/GtRbeRxgw+Mb4Ecpp1AKi9nY/1ZNku8LK9s6SfD1FthrZpH6f3v8Slv9qXLowev+YPcpLLTYMc8R5FdxlPGFEt9h6Y+oJe7uB9HzyCbnovAujWtJXjMxqTnYm4J/GHA+9Xt312xZpWrKSWIe6XLq0R516i9hG9em9x+gHzjG7UoW2kG0nXeGBQNP6DpwgILCS0qbYLqg==";
         $oAmount=1;
         $skipCashUrl="https://skipcashtest.azurewebsites.net";
         $formData = [
            "uid" => Str::uuid()->toString(),
            "keyId" => $skipCashKeyId,
            "amount" => number_format($oAmount, 2),
            "firstName" => 'Test',
            "lastName" => 'Last',
            "phone" => '8075089099',
            "email" => 'dipinpnambiar@gmail.com',
            "street" => "CA",
            "city" => "TempCity",
            "state" => "00",
            "country" => "00",
            "postCode" => "01238",
            "transactionId" => '6789',
            "orderId" => '123'
        ];

        $query = http_build_query($formData, "", ",");

        $signature = hash_hmac('sha256', json_encode($query), $skipCashSecretKey);
        //return $signature;

        $headers = [
            'Authorization: ' . base64_encode($signature),
            'Content-Type: application/json;charset=UTF-8',
            'x-client-id: ' . $skipCashClientId
        ];
        

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $skipCashUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);

        $response = curl_exec($ch);
        

        $data = json_decode($response);
        
        curl_close($ch);
        
        return $data->resultObj->id;
    }
    public function index(Request $request)
    {
    	$login = $request->validate([
    		'name' => 'required|string',
    		'password' => 'required|string'

    	]);
    	if(!Auth::attempt($login))
    	{
    		return response(['message','Invalid login credentials']);
    	}
    	$accessToken = Auth::user()->createToken('authToken')->accessToken;
    	return response(['user'=>Auth::user(), 'access_token' => $accessToken]);
    	
   
    }

    public function login(Request $request)
    {
    	$data = array();
        try
        {
    	   $phone = $request->input('cust_mobile_number');
    	   $passChk = $request->input('cust_password');
    	    $devType = $request->input('device_type');
           $devToken = $request->input('device_token');

           $validator = Validator::make($request->all(), [      
                'cust_mobile_number' => 'required',  
                'cust_password' => 'required',
                'device_type' => 'required',
                'device_token' => 'required',
            ],
            [   
                'cust_mobile_number.required' => "Customer Mobile Number is required", 
                'cust_password.required' => "Password is required",
                'device_type.required' => "Device Type is required",
                'device_toke.required' => "Device Token is required",
            ]);
            if(!$validator->fails())
                {
                    $getCurrency = Currency::where('currency_id','=',1)->first();
    	           $custCheck = Main_customer::where('cust_mobile','=',$phone)->first();
    	          


    	           if($custCheck)
    	               {
                        
    		              if(Hash::check($passChk, $custCheck->password))
        	                   {
                                    if($custCheck->profile_status!=0)
                                        {
                                            if($custCheck->otp_verify!=0)
                                                {                                                    
                                                    $data['status'] = 1;
                                                    $data['message'] = "Login Success";
                                                    $data['cust_id'] = $custCheck->customer_id;
                                                    $data['cust_fname'] = $custCheck->customer->cust_fname;
                                                    $data['cust_lname'] = $custCheck->customer->cust_lname;
                                                    $data['email_address'] = $custCheck->customer->email;
                                                    $data['access_token'] = $custCheck->customer->createToken('authToken')->accessToken;
                                                    $data['currency_id'] = strval($getCurrency->currency_id);
                                                    $data['currency_code'] = $getCurrency->currency_code;
                                                    Device::create([
                                                        'customer_id' => $custCheck->customer_id,
                                                        'device_type' => $devType,
                                                        'device_token' => $devToken
                                                    ]);
                                                }else{
                                                    $data['status'] = 2;
                                                    $data['message'] = "OTP not verified";
                                                     $data['cust_id'] = $custCheck->customer_id;
                                                }
                                        }else{
                                            $data['status'] = 4;
                                            $data['message'] = "Profile not Activated";
                                        }
                    	    	}else{
                    	    		$data['status'] = 3;
                    	    		$data['message'] = "Mobile Number or Password is Invalid";
                    	    	}
                    	}else{
                    		$data['status'] = 0;
                    		$data['message'] = "Invalid Login Details";
                    	}
                }else{
                    $data['errors'] = $validator->errors();
                    $data['message'] = "Login Failed";
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

    public function create(Request $request)
    {
        try
        {
        	$data = array();
        	$custDob = $request->input('cust_dob');
            $parseDob = Carbon\Carbon::parse($custDob)->format('Y-m-d');
            $sentTime = Carbon\Carbon::now();
            $sentTimeParse = $sentTime->format('Y-m-d H:i:s');
        	$expireTime = Carbon\Carbon::now()->addMinutes(45);
    	    $fetchTime = $expireTime->format('Y-m-d H:i:s');
            $customerCode     = '1234567890'; //being static
            $custShuffle = str_shuffle($customerCode);
            $custCode = substr($custShuffle, 1, 8);
        	$validator = Validator::make($request->all(), [       
                'cust_mobile_number' => 'required|unique:customers',
                'email' => 'required|unique:customers',
               'cust_qatar_id'=>'nullable|sometimes|unique:customers|min:11|max:11',
                'cust_passport_number' =>'required_without:cust_qatar_id|nullable|sometimes|unique:customers',
            ],
            [ 	'cust_mobile_number.unique' => "Mobile Number already taken",
                'cust_mobile_number.required' => "Mobile Number is required",
               'cust_qatar_id.unique' => "Qatar ID is already Taken.",
                'cust_passport_number.unique' => "Passport Number is already Taken.",
                'cust_qatar_id.min' => "Qatar ID must be 11 characters.",
                'cust_qatar_id.max' => "Qatar ID must be 11 characters.",
                'email.unique' => "Email address already Exist",
                'email.required' => "Email field is required"

            ]);
            if(!$validator->fails())
            {
                $password = $request->cust_password;
            	$encPass = Hash::make($password);
                $string  = '1234567890'; //otp
                $stringShuffle = str_shuffle($string);
                $otp = substr($stringShuffle, 1, 4);
                $custNationality = $request->cust_nationality;
                $getCntList = Country::where('country_id','=',$custNationality)->first();
                $countryId = $request->cust_nationality;
                $countryCode = $request->cust_mobile_code;
                $baseMobNumber = $request->cust_mobile_number;
                $mergCodeMob = $countryCode.$baseMobNumber;
                $replMobileNumber = str_replace('+', '', $mergCodeMob);
                
                
                ////////////////////----------------------------------------///////////////////////////////
        $countryCode = $request->cust_mobile_code;
        $atchSignCountryCode = '+'.$countryCode;
        $mobcode_to_send = substr($countryCode, strpos($countryCode, "+") + 1);
        
        $baseMobNumber = $request->cust_mobile_number;
        $smsGwMobNumber=$mobcode_to_send.$baseMobNumber;
        ///return $mergCodeMob;
        $custQtrId =  $request->cust_qatar_id;
        
        $firstName = $request->cust_fname;
        $lastName = $request->cust_lname;
        $mergdName = ucfirst($firstName) . ' ' . ucfirst($lastName);
        $nation = $request->cust_nationality;
        if($nation)
        {
            $fetchcountry = Country::where('country_id','=',$nation)->first();
            $countryName = $fetchcountry->country_name;
        }
             $client1 = new \GuzzleHttp\Client();
              if($custQtrId!=NULL)
              {
                  $api = $client1->get('http://130.61.97.192:201/F_CUSTOMERS?LookupText='.$firstName.'&PageSize=1&Skip=0&FC_MOBILE='.$baseMobNumber.'&FC_ID_NO='.$custQtrId);
                  
              }
              else
              {
                  $api = $client1->get('http://130.61.97.192:201/F_CUSTOMERS?LookupText='.$firstName.'&PageSize=1&Skip=0&FC_MOBILE='.$baseMobNumber.'&FC_ID_NO='.$request->cust_passport_number);
                  
              }
                
                
                
                $dat = $api->getBody()->getContents();
                $response = json_decode($dat, true);
                if($response){
                    $respItems = $response['Items'];
                    //dd($respItems);
                }
               
               
                if(sizeof($respItems))
                {
                    $custCode = $response['Items']['0']['FC_CUST_NO'];
                    
                }else{
                   
                    $custCode=null;
                }
                
                
                /////////////////////////////////////////////////////////////////////////////////

                $otpText =  "Dear User, ".$otp." is your one time password(OTP).Please enter the OTP to proceed.\nThankyou.\nTeam Rent solutions.";
                // $otp = "4847";
	        	$cust= $request->except('_token','cust_password','cust_nationality');
	            $currDetail = Customer::insertGetId($cust);
        
	          if(isset($custCode))
                {
                   Customer::where('customer_id',$currDetail)->update([
                    'cust_code' => $custCode,
                    'cust_password' => $encPass,
                    'cust_dob' => $parseDob,
                    'cust_mobile_code' => $atchSignCountryCode,
                    'cust_profile_status' =>1, 
                    'cust_nationality' => $request->cust_nationality,
                    'created_at' =>\Carbon\Carbon::now(),
                    'updated_at' =>\Carbon\Carbon::now()
                    ]); 
                }else{
                    Customer::where('customer_id',$currDetail)->update([
                    'cust_code' => NULL,
                    'cust_password' => $encPass,
                    'cust_dob' => $parseDob,
                    'cust_mobile_code' => $atchSignCountryCode,
                    'cust_nationality' => $request->cust_nationality,
                    'cust_profile_status' =>1,
                    'created_at' =>\Carbon\Carbon::now(),
                    'updated_at' =>\Carbon\Carbon::now()
                    ]); 
                }

                Main_customer::create([
                    'customer_id' => $currDetail,
                    'cust_mobile' => $request->input('cust_mobile_number'),
                    'password' => $encPass,
                    'email' => $request->input('email'),
                    'profile_status' => 1,
                    'created_at' =>\Carbon\Carbon::now(),
                    'updated_at' =>\Carbon\Carbon::now()

                ]);
	            Otp_verify::create([
	            	'cust_id' => $currDetail,
	            	'otp' => $otp,                   
	            	'expiry' => $fetchTime
	            ]);
/*
                $connection = new BulkGate\Message\Connection('17090', 'RQ23Z2PyBfPMbjPu64bWQ8BnXKKRyR5RzBS3DUPspQzWHNZeL2');
                $sender = new BulkGate\Sms\Sender($connection);
                $message = new BulkGate\Sms\Message($replMobileNumber, $otpText);

                $sender->send($message);*/
                 $curl=curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw1057&password=v7ute6lw&content=OTP+is+'.$otp.'+signup+to+Almana+Leasing+,+Thank+you&destination='.$mergCodeMob.'&source=97197&mask=AL%20Mana',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                ));

           $response = curl_exec($curl);
           

            curl_close($curl);

	            $data['customer_id'] = $currDetail;
	            $data['status'] = 1;
	        	$data['message'] = "Registration Success";

            }else{
            	$data['errors'] = $validator->errors();
            	$data['status'] = 0;
            	$data['message'] = "Registration Failed";
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

    
   public function verify_otp(Request $request)
    {
    	$data = array();
        try{
            $otp = $request->input('otp');
            $custId = $request->input('customer_id');
            $devType = $request->input('device_type');
           $devToken = $request->input('device_token');

           if($devType && $devToken!="")
           {
             $otpCheck = Otp_verify::where('cust_id','=',$custId)->where('otp','=',$otp)->first();
            if($otpCheck)
                {
                    $curTime = \Carbon\Carbon::now();
                    $fetchTime = $curTime->format('Y-m-d H:i:s');
                    $expTime = $otpCheck->expiry;
                    $expParse = $expTime->format('Y-m-d H:i:s');
                    if($fetchTime > $expParse)
                        {
                            $data['status'] = 2;
                            $data['OTP'] = $otpCheck->otp;
                            $data['message'] = "OTP Time Expired";
                        }else{


                            $upCustomer = Customer::where('customer_id','=',$custId)->update([
                                'cust_otp_verify' => '1'
                            ]);
                            Main_customer::where('customer_id','=',$custId)->update([
                                'otp_verify' => '1'
                            ]);

                             $getCurrency = Currency::where('currency_id','=',1)->first();
                            $custCheck = Main_customer::where('customer_id','=',$custId)->first();
                            $data['status'] = 1;
                            $data['message'] = "OTP Verification success.User Logged In";
                            $data['cust_id'] = $custCheck->customer_id;
                            $data['cust_fname'] = $custCheck->customer->cust_fname;
                            $data['cust_lname'] = $custCheck->customer->cust_lname;
                             $data['Email_address'] = $custCheck->customer->email;
                            $data['access_token'] = $custCheck->customer->createToken('authToken')->accessToken;
                            $data['currency_id'] = strval($getCurrency->currency_id);
                            $data['currency_code'] = $getCurrency->currency_code;
                                Device::create([
                                    'customer_id' => $custCheck->customer_id,
                                    'device_type' => $devType,
                                    'device_token' => $devToken
                                ]);

                           
                            // $data['cust_id'] = $custId;
                        }   
                }else{
                    $data['status'] = 0;
                    $data['message'] = "Invalid OTP Entered";
                }
           }else{
             $data['status'] = 3;
                    $data['message'] = "Device Type and Token Cannot be Empty";
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


    public function resentOtp(Request $request)
    {
        $data = array();
        try{
            $custId = $request->input('customer_id');

            if($custId)
            {
                $sentTime = Carbon\Carbon::now();
                $sentTimeParse = $sentTime->format('Y-m-d H:i:s');
                $expireTime = Carbon\Carbon::now()->addMinutes(45);
                $fetchTime = $expireTime->format('Y-m-d H:i:s');
                // $otp = "4847";

                $fetchCust = Customer::where('customer_id','=',$custId)->first();
                if($fetchCust)
                {
                    $fetchOtp = Otp_verify::where('cust_id','=',$custId)->first();
                  
                $otpInTb = $fetchOtp->otp;
                $countryCode = $fetchCust->cust_mobile_code;
                $baseMobNumber = $fetchCust->cust_mobile_number;
                $mergCodeMob = $countryCode.$baseMobNumber;
                  $mobcode_to_send = substr($fetchCust->cust_mobile_code, strpos($fetchCust->cust_mobile_code, "+") + 1);
               $baseMobNumber = $fetchCust->cust_mobile_number;
               $smsGwMobNumber=$mobcode_to_send.$baseMobNumber;
               $countryCode = $fetchCust->cust_mobile_code;
                $replMobileNumber = str_replace('+', '', $mergCodeMob);
                $otpText =  "Dear User, ".$otpInTb." is your one time password(OTP).Please enter the OTP to proceed.\nThankyou.\nTeam Rent solutions.";
                Otp_verify::where('cust_id','=',$custId)->update([
                    'otp' => $otpInTb,
                    'expiry' => $fetchTime

                ]);
               /* $connection = new BulkGate\Message\Connection('17090', 'RQ23Z2PyBfPMbjPu64bWQ8BnXKKRyR5RzBS3DUPspQzWHNZeL2');

                $sender = new BulkGate\Sms\Sender($connection);
                $message = new BulkGate\Sms\Message($replMobileNumber, $otpText);
                $sender->send($message);*/
                 $curl=curl_init();

                curl_setopt_array($curl, array(
                    
                  CURLOPT_URL => 'https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw1057&password=v7ute6lw&content=OTP+is+'.$otpInTb.'+signup+to+Almana+Leasing+,+Thank+you&destination='.$smsGwMobNumber.'&source=97197&mask=AL%20Mana',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                ));

           $response = curl_exec($curl);

            curl_close($curl);

                $data['status'] = 1;
                $data['message'] = "OTP Sent to regsitered Mobile Number";
                }else{
                    $data['status'] = 0;
                $data['message'] = "No such customer exist";
                }
                
            }else{
                $data['status'] = 0;
                $data['message'] = "Customer Id is Required";
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


 public function checkMobile(Request $request){
      $data = array();
        try{
        $mobNumber=$request->mob_number;
        $mobCheck =Main_Customer::where("cust_mobile",'=',$mobNumber)->first();
        if($mobCheck)
        {
            $data['status'] = 0;
            $data['message'] = "Mobile number already taken";

        }else{
            $data['status'] = 1;
            $data['message'] = "Mobile number accepted";
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
   




















}
