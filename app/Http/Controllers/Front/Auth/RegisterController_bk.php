<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\User;
use App\Models\Country;
use Carbon;
use Crypt;
use App\Models\Customer;
use App\Models\Otp_verify;
use App\Models\Api\Forgot_password_otp;
use App\Models\Main_customer;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use BulkGate;
use GuzzleHttp\Client;
use Illuminate\Validation\Rule;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    
    
    public function showRegistrationForm()
    {
       
        $fetchCont = Country::orderBy('country_id','ASC')->get();
        return view('front-end.elements.user.register',compact('fetchCont'));
    }
    
    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = "/";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
       
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(Request $request)
    {
        $countryCode = $request->cust_mobile_code;
        $baseMobNumber = $request->cust_mobile_number;
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
        
        
        
               /* $client1 = new \GuzzleHttp\Client();
                $api = $client1->get('http://rentsolution.dyndns.info:200/F_CUSTOMERS?LookupText='.$firstName.'&PageSize=1&Skip=0&FC_MOBILE='.$baseMobNumber.'&FC_ID_NO='.$custQtrId);
                
                
                $data = $api->getBody()->getContents();
                $response = json_decode($data, true);
                if($response){
                    $respItems = $response['Items'];
                }
               
               
                if(sizeof($respItems))
                {
                    $custCode = $response['Items']['0']['FC_CUST_NO'];
                    
                }else{
                    //post customer details
                        $client = new \GuzzleHttp\Client();
                        $api2 =   $client->post('http://rentsolution.dyndns.info:200/F_CUSTOMERS',
                        array(
                            'form_params' => array(
                                'FC_LNAME' => $mergdName,
                                'FC_EMAIL' => $request->email,
                                'FC_MOBILE' => $request->cust_mobile_number,
                                'FC_ID_NO' => $request->cust_qatar_id,
                                'FC_NATION' => $countryName,
                            )
                        )
                    );
                    $data2 = $api2->getBody()->getContents();
                    $response2 = json_decode($data2, true);
                    $custCode = reset($response2);
                }
               */
                
                
                
        $checkMobDuplictn = Customer::where('cust_mobile_code','=',$countryCode)->where('cust_mobile_number','=',$baseMobNumber)->first();
        
        if(!$checkMobDuplictn)
        {
            
            $custDob = $request->input('cust_dob');
            $parseDob = Carbon\Carbon::parse($custDob)->format('Y-m-d');
            $sentTime = Carbon\Carbon::now();
            $sentTimeParse = $sentTime->format('Y-m-d H:i:s');
            $expireTime = Carbon\Carbon::now()->addMinutes(45);
            $fetchTime = $expireTime->format('Y-m-d H:i:s');
            // $customerCode     = '1234567890'; //being static
            // $custShuffle = str_shuffle($customerCode);
            // $custCode = substr($custShuffle, 1, 4);
            
            $validator = Validator::make($request->all(), [       
                'cust_mobile_number' => 'required|unique:customers|numeric',
                'email' => 'required|email|unique:customers',
                'cust_qatar_id'=>'required|unique:customers',
                'cust_passport_number' =>'required|unique:customers',
                'password'=>'required|string|min:8|confirmed'
            ],
            [   
                'cust_mobile_number.unique' => "Mobile Number already taken",
                'cust_mobile_number.required' => "Mobile Number is required",
                'cust_mobile_number.numeric' => "Mobile number should not contain alphabets",
                'cust_qatar_id.unique' => "Qatar ID is already Taken.",
                'cust_passport_number.unique' => "Passport Number is already Taken.",
                'email.unique' => "Email address already Exist",
                'email.required' => "Email field is required"

            ]);
            


             if(!$validator->fails())
            {
                $password = $request->password;
                $encPass = Hash::make($password);
                // dd(Hash::check($password, $encPass));
                $string  = '1234567890'; //otp
                $stringShuffle = str_shuffle($string);
                $otp = substr($stringShuffle, 1, 4);
                
                $mergCodeMob = $countryCode.$baseMobNumber;
                $otpText =  "Dear User, ".$otp." is your one time password(OTP).Please enter the OTP to proceed.\nThankyou.\nTeam Rent solutions.";
                

                // $otp = "4847";
                $cust= $request->except('_token','password','password_confirmation','cust_dob');
                $currDetail = Customer::insertGetId($cust);
                
                
                if(isset($custCode))
                {
                   Customer::where('customer_id',$currDetail)->update([
                    'cust_code' => $custCode,
                    'cust_password' => $encPass,
                    'cust_dob' => $parseDob,
                    'cust_profile_status' =>1,
                    'created_at' =>\Carbon\Carbon::now(),
                    'updated_at' =>\Carbon\Carbon::now()
                    ]); 
                }else{
                    Customer::where('customer_id',$currDetail)->update([
                    'cust_code' => NULL,
                    'cust_password' => $encPass,
                    'cust_dob' => $parseDob,
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
            //     $connection = new BulkGate\Message\Connection('17090', 'RQ23Z2PyBfPMbjPu64bWQ8BnXKKRyR5RzBS3DUPspQzWHNZeL2');

            //     $sender = new BulkGate\Sms\Sender($connection);
            //     $message = new BulkGate\Sms\Message($mergCodeMob, $otpText);

            //   $sender->send($message);

                $encId = Crypt::encryptString($currDetail);
                return redirect('user-otp-verify/'.$encId);

            }else{
              return redirect()->back()->withInput()->withErrors($validator->errors());
            }
        }else{
            return redirect()->back()->with('status-error','Customer Mobile Number Exist. Please Try another Number.');
        }

       
    }

    public function otpVerify($id)
    {
        $decrUsrId = Crypt::decryptString($id);
        return view('front-end.elements.user.otp-verify',compact('decrUsrId'));
       
        
      

    }

public function checkOtp(Request $request)
{
    $usrId = $request->input('user_id');
    $otp = $request->input('otp');
    $otpCheck = Otp_verify::where('cust_id','=',$usrId)->where('otp','=',$otp)->first();
        if($otpCheck)
            {
                $curTime = \Carbon\Carbon::now();
                $fetchTime = $curTime->format('Y-m-d H:i:s');
                $expTime = $otpCheck->expiry;
                $expParse = $expTime->format('Y-m-d H:i:s');
                if($fetchTime > $expParse)
                    {
                        return back()->with('status','OTP Time Expired');
                    }else{
                        $upCustomer = Customer::where('customer_id','=',$usrId)->update([
                                'cust_otp_verify' => '1'
                        ]);
                        Main_customer::where('customer_id','=',$usrId)->update([
                            'profile_status' => '1',
                                'otp_verify' => '1'
                        ]);
                        return redirect('user-login')->with('status','Registration Complete');
                    }   
                }else{
                    return back()->with('status','Invalid OTP entered');
                }

}

public function resendOtp($id)
{
    $sentTime = Carbon\Carbon::now();
    $sentTimeParse = $sentTime->format('Y-m-d H:i:s');
    $expireTime = Carbon\Carbon::now()->addMinutes(45);
    $fetchTime = $expireTime->format('Y-m-d H:i:s');
    // $otp = "4847";
    $fetchCust = Customer::where('customer_id','=',$id)->first();
    $fetchOtp = Otp_verify::where('cust_id','=',$id)->first();
    $otpInTb = $fetchOtp->otp;
    $countryCode = $fetchCust->cust_mobile_code;
                $baseMobNumber = $fetchCust->cust_mobile_number;
                $mergCodeMob = $countryCode.$baseMobNumber;
                $otpText =  "Dear User, ".$otpInTb." is your one time password(OTP).Please enter the OTP to proceed.\nThankyou.\nTeam Rent solutions.";
    Otp_verify::where('cust_id','=',$id)->update([
        'otp' => $otpInTb,
        'expiry' => $fetchTime

    ]);
    //  $connection = new BulkGate\Message\Connection('17090', 'RQ23Z2PyBfPMbjPu64bWQ8BnXKKRyR5RzBS3DUPspQzWHNZeL2');

    //             $sender = new BulkGate\Sms\Sender($connection);
    //             $message = new BulkGate\Sms\Message($mergCodeMob, $otpText);

    //             $sender->send($message);
    return back()->with('resend-success','OTP sent to mobile');
}


public function test(Request $request)
{
    $connection = new BulkGate\Message\Connection('17090', 'RQ23Z2PyBfPMbjPu64bWQ8BnXKKRyR5RzBS3DUPspQzWHNZeL2');

    $sender = new BulkGate\Sms\Sender($connection);
    $message = new BulkGate\Sms\Message('917559854605', 'test message');

    $sender->send($message);
    echo "sent";
}


public function resetPasswordView(Request $request)
{
    $fetchCont = Country::orderBy('country_id','ASC')->get();
    return view('front-end.elements.user.forgot-password.mobile-verify',compact('fetchCont'));
}


public function verifyMobile(Request $request){
       
            
        	//$mobCodereq = $request->cust_mobile_code;
        		//$mobCode = ltrim($mobCodereq, '+');
        		$mobCode=$request->cust_mobile_code;
        	$mobNumber=$request->mobile_number;
        $mobCheck =Customer::where("cust_mobile_number",'=',$mobNumber)->where('cust_mobile_code','=',$mobCode)->first();
       
        if($mobCheck)
        {

        	$custId = $mobCheck->customer_id;

        	$validator = Validator::make($request->all(), [       
                'cust_mobile_code' => 'required',
                'mobile_number' => 'required'
            ],
            [ 	'cust_mobile_code.required' => "Country Code is required",
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

                // $connection = new BulkGate\Message\Connection('17090', 'RQ23Z2PyBfPMbjPu64bWQ8BnXKKRyR5RzBS3DUPspQzWHNZeL2');

                // $sender = new BulkGate\Sms\Sender($connection);
                // $message = new BulkGate\Sms\Message($replMobileNumber, $otpText);

                // $sender->send($message);

            	return view('front-end.elements.user.forgot-password.otp-verify',compact('custId'));

            }else{
            	
             return redirect()->back()->withInput()->withErrors($validator->errors());
            }

        }else{
           return back()->with('error-cust','Customer Doesnt Exist');
        }

       
       

    }
    
    
    public function custVerifyOtp(Request $request)
    {
        
        $otp = $request->input('otp');
        $custId = $request->customer_id;
        $otpCheck = Forgot_password_otp::where('customer_id','=',$custId)->where('f_otp','=',$otp)->first();
       
        if($otpCheck)
                {
                    $curTime = \Carbon\Carbon::now();

                    $fetchTime = $curTime->format('Y-m-d H:i:s');
                    $expTime = $otpCheck->expiry;

                    $expParse = $expTime->format('Y-m-d H:i:s');
                   
                    if($fetchTime > $expTime)
                        {
                            return back()->with('status','OTP Time Expired');
                        }else{
                            $encId = Crypt::encryptString($custId);
                           return redirect('customer/reset-password/confirm/'.$encId);
                        }   
                }else{
                   return back()->with('status','Invalid OTP Entered');
                }
    }
    
    
    public function custResetconfirm($id, Request $request)
    {
        $custId = Crypt::decryptString($id);
        return view('front-end.elements.user.forgot-password.password-reset',compact('custId'));
        	
    }
    
    
    public function updatePass(Request $request)
    {
       
        $custId = $request->customer_id;
        
        			$fetchCustDet = Main_customer::where('customer_id','=',$custId)->first();
        			
        			$validator = Validator::make($request->all(), [      
                		'password'=>'required|string|min:8|confirmed'
            		]);
            	
            			
            		if(!$validator->fails())
                		{
                		   
                			 $encPass = Hash::make($request->input('password'));
		                    Customer::where('customer_id', $custId)->update(['cust_password' => $encPass]);
		                    Main_customer::where('customer_id', $custId)->update(['password' => $encPass]);
		                   return redirect('user-login')->with('status','Password Reset Successful.');

	                	}else{
		                    return redirect()->back()->withInput()->withErrors($validator->errors());
                		}	
    }






}
