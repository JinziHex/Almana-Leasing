<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Otp_verify;
use App\Models\Api\Forgot_password_otp;
use App\Models\Main_customer;
use App\Models\Device;
use Crypt;
use Auth;
use Hash;
use Carbon;
use Validator;
use BulkGate;

class PasswordController extends Controller
{
    public function verifyMobile(Request $request){
      $data = array();
        try{
        	$mobCode = $request->country_code;
        	$mobNumber=$request->mobile_number;
        	$attachsign = "+".$mobCode;
  	
        $mobCheck =Customer::where("cust_mobile_number",'=',$mobNumber)->where('cust_mobile_code','=',$attachsign)->first();
       
        if($mobCheck)
        {

        	$custId = $mobCheck->customer_id;

        	$validator = Validator::make($request->all(), [       
                'country_code' => 'required',
                'mobile_number' => 'required'
            ],
            [ 	'country_code.required' => "Country Code is required",
                'mobile_number.required' => "Mobile Number is required",
                

            ]);

            if(!$validator->fails())
            {
	        	$sentTime = Carbon\Carbon::now();
	            $sentTimeParse = $sentTime->format('Y-m-d H:i:s');
	        	$expireTime = Carbon\Carbon::now()->addMinutes(45);
	    	    $fetchTime = $expireTime->format('Y-m-d H:i:s');

        	 	$string  = '1234567890'; //otp
                $stringShuffle = str_shuffle($string);
                $otp = substr($stringShuffle, 1, 4);
                $countryCode = $mobCode;
                $baseMobNumber = $mobNumber;
                $mergCodeMob = $countryCode.$baseMobNumber;
                $replMobileNumber = str_replace('+', '', $mergCodeMob);

                $otpText =  "Dear User, ".$otp." is your one time password(OTP) for password reset.Please enter the OTP to proceed.\nThankyou.\nTeam Rent solutions.";
                Forgot_password_otp::create([
	            	'customer_id' => $custId,
	            	'f_otp' => $otp,                   
	            	'expiry' => $fetchTime
	            ]);

               /* $connection = new BulkGate\Message\Connection('17090', 'RQ23Z2PyBfPMbjPu64bWQ8BnXKKRyR5RzBS3DUPspQzWHNZeL2');

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

            	$data['status'] = 1;
            	$data['Customer_Id'] = $custId;
            	$data['message'] = "OTP Sent to registered mobile number";

            }else{
            	
            	$data['status'] = 0;
            	$data['errors'] = $validator->errors();
            	$data['message'] = "Verification Failed";
            }

        }else{
            $data['status'] = 0;
            $data['message'] = "Customer Does not exist";
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

    
    public function verifyOtp(Request $request)
    {
    	$data = array();
        try{
            $otp = $request->input('otp');
            $mobCode = $request->country_code;
        	$mobNumber=$request->mobile_number;
        	$attachsign = "+".$mobCode;

        	$mobCheck =Customer::where("cust_mobile_number",'=',$mobNumber)->where('cust_mobile_code','=',$attachsign)->first();
        	if($mobCheck)
        	{
        		$custId = $mobCheck->customer_id;
        		$otpCheck = Forgot_password_otp::where('customer_id','=',$custId)->where('f_otp','=',$otp)->first();

            if($otpCheck)
                {
                    $curTime = \Carbon\Carbon::now();

                    $fetchTime = $curTime->format('Y-m-d H:i:s');
                    $expTime = $otpCheck->expiry;

                    // $expParse = $expTime->format('Y-m-d H:i:s');

                    if($fetchTime > $expTime)
                        {
                            $data['status'] = 2;
                            $data['OTP'] = $otpCheck->f_otp;
                            $data['message'] = "OTP Time Expired";
                        }else{

                            $data['status'] = 1;
                            $data['message'] = "OTP verification success. Enter a new password.";
                        }   
                }else{
                    $data['status'] = 0;
                    $data['message'] = "Invalid OTP Entered";
                }
        	}else{
            $data['status'] = 0;
            $data['message'] = "Customer Does not exist";
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



public function resetPassword(Request $request)
    {
        $data=array();
        try
        {
        	$mobCode = $request->country_code;
        	$mobNumber=$request->mobile_number;
        	$attachsign = "+".$mobCode;
        	$mobCheck =Customer::where("cust_mobile_number",'=',$mobNumber)->where('cust_mobile_code','=',$attachsign)->first();
        	
        	if($mobCheck)
        		{
        			$custId = $mobCheck->customer_id;
        			$fetchCustDet = Main_customer::where('customer_id','=',$custId)->first();
        			$validator = Validator::make($request->all(), [      
                		'password'=>'required|string|min:8'
            		]);

            		if(!$validator->fails())
                		{
                			 $encPass = Hash::make($request->input('password'));
		                    Customer::where('customer_id', $custId)->update(['cust_password' => $encPass]);
		                    Main_customer::where('customer_id', $custId)->update(['password' => $encPass]);
		                    $data['status'] = 1;
		                    $data['message'] = "Password Changed successfully";

	                	}else{
		                    $data['status'] = 0;
		                    $data['errors'] = $validator->errors(); 
                		}	


        		}else{
            		$data['status'] = 0;
            		$data['message'] = "Customer Does not exist";
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
