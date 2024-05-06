<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Modal;
use App\CustomerCoupon;
use App\Coupon;
use App\Models\Booking;
use App\Models\Device;
use App\Models\Mode_rate;
use App\Models\Model_image;
use App\Models\City;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Model_specification;
use App\Models\City_location;
use App\Models\Customer;
use App\Models\Api\Notification;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Crypt;
use App\Helpers\Helper;
use Auth;
use  Carbon\Carbon;
use Validator;
use Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{

    public function get_info(Request $request)
    {
        $data = array();
        $model = array();
        $customer = array();
        
        try
        {
            // $id = Auth::guard('api')->user()->customer_id;
            $modelId = $request->input('model_id');
            $fetchModel = Modal::where('modal_id','=',$modelId)->first(); 
            $ModelImage = Model_image::where('model_id',$fetchModel->modal_id)->where('model_image_flag','=',0)->first();
            $modelSpec =  Model_specification::where('model_id','=',$fetchModel->modal_id)->get();
            $id = $request->input('customer_id');
            $parseInt = (int)$id;
            $fetchCust = Customer::where('customer_id','=',$parseInt)->first();
            $spec=array();
                foreach ($modelSpec as $resSpecs) {
                $specvl = $resSpecs->specs['spec_name'];
              
                $specImg = '/assets/uploads/specifications/icons/'.$resSpecs->specs['spec_icon'];
                array_push($spec,$specvl,$specImg);
                }
            $getTerms = Setting::where('id','=',1)->first();
            $getAdditionalInfo = Setting::where('id','=',2)->first();
            
          
            
            if($fetchCust)
            {
                $model['Model_id'] = $fetchModel->modal_id;
                $model['Model_Name'] = $fetchModel->modal_name;
                $model['Makers'] = $fetchModel->maker->maker_name;
                $model['Image'] = '/assets/uploads/models/'.$ModelImage->model_image;
                $model['Model_Available'] = $fetchModel->rdy_count;
                $model['specifications'] = $spec;
                // $data['specifications'] = $spec;
                $customer['Customer_id'] = $fetchCust->customer_id;
                $customer['Customer_first_name'] =  $fetchCust->cust_fname;
                $customer['Customer_Last_name'] =  $fetchCust->cust_lname;
                $customer['Mobile_code'] = $fetchCust->cust_mobile_code;
                $customer['Mobile_number'] = $fetchCust->cust_mobile_number;
                $customer['Date_of_birth'] = $fetchCust->cust_dob;
                $customer['Qatar_id'] = $fetchCust->cust_qatar_id;
                $customer['Passport_number']  = $fetchCust->cust_passport_number;
                $customer['License_number']  = @$fetchCust->cust_driving_license_no??'';
                $customer['License_date']  = @$fetchCust->cust_license_issued_date??'' ;
                $customer['License_country']  = @$fetchCust->cust_license_issued_country??'' ;
                 $customer['License_country_name']  = @$fetchCust->licenseCountry['country_name'];
                $customer['Nationality_id'] = $fetchCust->cust_nationality;
                $customer['Nationality'] = @$fetchCust->nationality['country_name'];
                 $customer['City_id'] = $fetchCust->cust_city;
                 $customer['City'] = @$fetchCust->custCity['city_name'];
                 $customer['City_Arb'] = @$fetchCust->custCity['ar_city_name'];
                 $customer['Location_id'] = $fetchCust->cust_state;
                 $customer['Location'] = @$fetchCust->location['location_name'];
                 $customer['Location_Arb'] = @$fetchCust->location['ar_location_name'];
                 $customer['Billing_country_id'] = $fetchCust->cust_bill_country;
                 $customer['Billing_country'] = @$fetchCust->billcountry['country_name'];
                $customer['Address_line_1'] = $request->cust_address_line_1??$fetchCust->cust_address_line_1;
                $customer['Address_line_2'] =$request->cust_address_line_2?? $fetchCust->cust_address_line_2;

            }
            //  array_push($data,$model); 
            // array_push($data,$customer); 
             $data['Model Details'] = $model;
              $data['Customer Information'] = $customer;
              $data['Terms_and_conditions_Line_1'] = strip_tags($getTerms->st_description);
            $data['Terms_and_conditions_Line_2'] = strip_tags($getTerms->st_description_line_2);
             $data['Additional_info_Line_1'] = strip_tags($getAdditionalInfo->st_description);
            $data['Additional_info_Line_2'] = strip_tags($getAdditionalInfo->st_description_line_2);
                           
            return response($data);
        }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];

            return response($response);
        }
    }


    public function save(Request $request)
    {
        
    	$data = array();
        $frmDate = $request->input('book_from_date');
        // $countFromDate = Carbon::parse($fromDat); //for counting numbr of days 
        // $parseFromDate = Carbon::parse($fromDat)->format('Y-m-d');
        $toDate = $request->input('book_to_date');
        // $countToDt = Carbon::parse($toDat); //for counting number of days 
        // $parseToDt = Carbon::parse($toDat)->format('Y-m-d');
        $pickupTime = $request->input('book_pickup_time');
        // $parsePickTime = Carbon::parse($pickTime)->format('H:i:s'); //24 hours format
        $returnTime = $request->input('book_return_time');
        // $parseretnTime = Carbon::parse($retnTime)->format('H:i:s');
        $modelId = $request->input('book_car_model');
        $coupon_code=$request->coupon_code??NULL;
        
        $ftchMake = Modal::where('modal_id','=',$modelId)->first(); //get maker name 
        $makers = $ftchMake->maker->maker_name;
        
        $parseFrmDt = Helper::parseCarbon($frmDate); 
          $parseToDate = Helper::parseCarbon($toDate);
          $parsePickTime = Helper::parseCarbon($pickupTime);
          $parseRetTime = Helper::parseCarbon($returnTime);
          $diff = $parsePickTime->diffInHours($parseRetTime);
          $diffDays = $parseFrmDt->diffInDays($parseToDate);
          
          $combinedfrom = date('Y-m-d H:i:s', strtotime("$frmDate $pickupTime"));
          $combinedto = date('Y-m-d H:i:s', strtotime("$toDate $returnTime"));
          $parsecombinefrom = Helper::parseCarbon($combinedfrom); 
          $parsecombineto = Helper::parseCarbon($combinedto); 
          $diffDays2 = $parsecombinefrom->diffInDays($parsecombineto);
          $mins            = $parseRetTime->diffInMinutes($parsePickTime, true);
          $totMins = ($mins/60);
          
        
         
          //get number of days
          if($totMins > 4 && $diff <= 12  && $diffDays2 >= 1)
          {
             $days=$parseFrmDt->diffInDays($parseToDate)+1;  
          }else{
              $days=$parseFrmDt->diffInDays($parseToDate); 
          }
          
        // $days = $countFromDate->diffInDays($countToDt);
        
        $typoo = Helper::setType($days);
        $rateType = Mode_rate::where('rate_type_id','=',$typoo)->first();
        $fetchTypName = $rateType->rates->rate_type_code;
        $referIdCheck = Booking::latest('book_id')->first(); //check if any booking exist in tb and fetch its reference id
       //$referIdCheck = Booking::latest('book_id')->first(); //check if any booking exist in tb and fetch its reference id
      $date = date('Ymd');
      $i=1;
      /*if(is_null($referIdCheck))
      {
          $num=rand(10,99);
         $ref_number = $date.$i;
      }
      else
      {
          $orderid  = $referIdCheck->book_ref_id;
         // dd($orderid);
          $orderdate = mb_substr($orderid, 0, 8);
          $ids = substr($orderid, 8);
          if($orderdate == $date){
              $ids++;
               $num=rand(10,99);
              $ref_number = $orderdate.$ids;
             // dd($app_number,"hii");
          }
          else{
               $num=rand(10,99);
              $ref_number = $date.$i;
            
          }  
      }*/
      if(is_null($referIdCheck))
      {
          $num=rand(10,99);
         $ref_number = $date.'000'.$i;
      }
      else
      {
          $orderid  = $referIdCheck->book_ref_id;
         // dd($orderid);
          $orderdate = mb_substr($orderid, 0, 8);
          $ids = substr($orderid, 8);
          if($orderdate == $date){
              $ids++;
               $num=rand(10,99);
               if($ids<10)
               {
                   $ref_number = $orderdate.'000'.$ids;
                   
               }
               else
               {
                   $ref_number = $orderdate.'00'.$ids;
                   
               }
              
             // dd($app_number,"hii");
          }
          else{
               $num=rand(10,99);
              $ref_number = $date.'000'.$i;
            
          }  
      }
      $ReferId=$ref_number;
        $validator = Helper::validateBooking($request->all());
        
        if ($request->hasFile('book_file')) {
            $docFile = time() . '.' . $request->book_file->extension();
            $request->book_file->move('assets/uploads/booking', $docFile);
        }
        
        if(!$validator->fails())
            {
                $datas= $request->except('_token');
                $currDetail = Booking::insertGetId($datas);
                Booking::where('book_id','=',$currDetail)->update([
                    'book_ref_id' => $ReferId,
                    'book_from_date' => $parseFrmDt,
                    'book_to_date' => $parseToDate,
                    'book_file' => $docFile ?? '',
                    'book_pickup_time' => $parsePickTime,
                    'book_return_time' => $parseRetTime, 
                    'book_total_days' => $days,
                    'book_car_rate_type' => $fetchTypName,
                    'coupon_code'=>$coupon_code,
                    // 'payment_status' =>1,
                    'active_flag' =>1,
                    'book_status' =>1,  //pending // it will become confirmed only wen payment is completed
                    'created_at' =>\Carbon\Carbon::now(),
                    'updated_at' =>\Carbon\Carbon::now()
                ]);
                //payment gateway 
                
                
                
                	$orderid= $this->generateRandomString(6);
	        $merchant="DB95927"; 
        	$apipassword="afbc40219aa0e4eb35e3ebfd46d809e8"; 
	        $amount=$request->input('book_total_rate');
	        $returnUrl = URL::to('booking-success');
	        $currency = "QAR";

	       /* $url = "https://dohabank.gateway.mastercard.com/api/rest/version/57/merchant/DB95927/session";
	
        	$ch = curl_init($url);
        	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        	curl_setopt($ch, CURLOPT_USERPWD, "merchant.DB95927:afbc40219aa0e4eb35e3ebfd46d809e8");
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        	$headers = array(
        	   "Authorization: Basic bWVyY2hhbnQuREI5NTkyNzphZmJjNDAyMTlhYTBlNGViMzVlM2ViZmQ0NmQ4MDllOA==",
        	   "Content-Type: application/json",
        	);
	
	
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data1 = <<<DATA
{

    "apiOperation": "CREATE_CHECKOUT_SESSION",

    "interaction": {

        "operation": "PURCHASE"

    },

    "order"      : {

        "amount"     : "$amount",

        "currency"   : "$currency",

        "description": "Car Booking",

        "id": "$orderid"

    }

}
DATA;


curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);

//for debug only!
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($ch);

$response = json_decode($resp);


// exit;
curl_close($ch);

$sessionid = $response->session->id;*/
/*******************Skip cash****************************************/
$bookingInfo = Booking::where('book_id','=',$currDetail)->first();
$customer=Customer::where('customer_id','=',$bookingInfo->book_cust_id)->first();

       
         $skipCashKeyId="ec7afae2-a8b3-4bbd-9231-9eec675cca52";
         $skipCashClientId="c6c70e68-7478-4fa0-9d43-1c332d40d627";
         $skipCashSecretKey="gwaqDJ5zYwZGtAaURikpoJO9SF2UzECjppc9eqkH62lXh5sPnwv69s+5AaZwc6eQtghL76uoZPYTOTOBjVtPYFipbt6EGsD93tns4kC8BIWLZI7LpwbqrejuFuFlN0m6+SNgYLqWthmOxBXCKPi+W1TICI7yahEGmyXCLG7ZtBKGDV4v4rrlEhELnoGk3e5ODeO82izb0BgKfP2p4AU2NgWrheIV6M+MwcWiqyqa9YwgocKcOUQjMzi6hG2A9ibF2Z/Yo8/c0NihdrSwfPkj1Cd3g7hzw3/IdiQXdT+xUWRLgf/XEyyiUNRgOHQw3ADjHw59XqKsB+Isok9jkMgHRJalM2ebMZZ5voIcCPjYeMKfc8NLOIxWsibsvB4aq+eX0gyG6cXvSRDSCXaxDOJYaxEXdyrWPmZk4Mkos8hEv0MlrN4j1XtpXLoSLp2IkhLjm4Q3W8DHvcRyIEYj3Xx8UWpAK/OibXDfGpqiA/2JS6YDtukT3kEia0fqwXoETF4Ur7uCWXD5qsNHNCQjbxg28w==";
         $oAmount=1;
         $uid=Str::uuid()->toString();
         $skipCashUrl="https://api.skipcash.app/api/v1/payments";
         $customer_first_name=$customer->cust_fname;
         $customer_last_name=$customer->cust_lname;
         $customer_email=$customer->email;
         $customer_mobile=$customer->cust_mobile_number;
         $formData = [
            "Uid" =>$uid ,
            "KeyId" =>$skipCashKeyId,
            "Amount" => $request->input('book_total_rate'),
            "FirstName" =>ucfirst($customer_first_name),
            "LastName" => ucfirst($customer_last_name),
            "Phone" => "918075089099",
            "Email" => $customer_email,
            "Street" => "Al Samriya St 10",
            "City" => "Doha",
            "State" => "AV",
            "Country" => "QA",
            "PostalCode" => "670307",
            "TransactionId" => $ReferId,
            "Custom1"=>"yes"
        ];
      
        $qry = http_build_query($formData," ", ",");//Combining all the request fields into key=value line separated by comma:
        $query=urldecode($qry);
         //dd($query,$TotalAmnt,$ReferId);
        $sha_signature = hash_hmac('sha256',$query,$skipCashSecretKey,true);//Encrypt using the algorithm HMACSHA256
        $signature=base64_encode($sha_signature);//Convert to base 64 format
        $headers = [
            'Authorization: '.$signature,
            'Content-Type: application/json;charset=UTF-8',
            'x-client-id: ' .$skipCashClientId
        ];
        
        $chh = curl_init();
        curl_setopt($chh, CURLOPT_URL,$skipCashUrl);
        curl_setopt($chh, CURLOPT_POST, true);
        curl_setopt($chh, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chh, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($chh, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($chh, CURLOPT_POSTFIELDS, json_encode($formData));

        $re = curl_exec($chh);
        

       $d = json_decode($re);
        
        curl_close($chh);
        
         //return $re;
        //dd($d);
          $reslt = $d->resultObj;
          $payUrl = $reslt->payUrl;
         // return redirect()->intended($payUrl);
          //dd($payUrl);
        // return redirect()->to($payUrl);
         
        

/****************End skip cash***************************************/
$sessionid=rand(1000,9999);

                Booking::where('book_id','=',$currDetail)->update([
                    'book_ref_id' => $ReferId,
                    'payment_session_id' => null
                ]);

                
                //payment gateway end
                
                if($coupon_code!=NULL)
                {
                    $cust_id=$bookingInfo->book_cust_id;
                    $coupon=Coupon::where('coupon_code',$coupon_code)->first();
                    if($coupon)
                    {
                    $customer_coupon=CustomerCoupon::where('customer_id',$cust_id)->where('coupon_id',@$coupon->id)->first();
                    $customer_coupon->is_applied=1;
                    $customer_coupon->update();
                    
                    }
                    
            
            
                }
       if($coupon_code!=NULL)
        {
            $coupon_discount=($request->input('book_daily_rate')*$days)-$request->input('book_total_rate');
            
        }
        else
        {
            $coupon_discount=0;
            
        }
        
            //save notification
            $statusName = "Under Process";
            /*$notfContent = "Your Booking with Reference Number: " . $ReferId . " is " . $statusName;
            Notification::create([
                    'customer_id' => $bookingInfo->book_cust_id,
                    'notification_title' => "Booking Status",
                    'notification_content' => $notfContent,
                    'notification_status' => 1
                ]);
                
                
                 //push notification
            $devices = Device::where('customer_id', $bookingInfo->book_cust_id)->get();

            foreach ($devices as $device) {
                $notification = [];
                $title = "Booking Success";
                $body = "New booking with booking id " . $ReferId . " has been saved successfully";
                $clickAction = "ReservationFragment";
                $type = "Booking";
                $notification[] = Helper::customerNotification($device->device_token, $title, $body, $clickAction, $type);
                $data['notification'] = $notification;
            }*/
             
               if($customer!=NULL)
                {
                    
                    $statusName = "Under Process";
                     $bkmodelImage = $bookingInfo->model->modelImage->model_image;

                    
             
                    $customer_first_name=$customer->cust_fname;
                    $customer_last_name=$customer->cust_lname;
                    $customer_full_name=$customer->fname.''.$customer->cust_lname;
                    $customer_dob=$customer->cust_dob;
                    $customer_email=$customer->email;
                    $customer_address=$bookingInfo->book_bill_cust_address_1.' '.$bookingInfo->book_bill_cust_address_2;
                    $customer_license_no=$customer->cust_driving_license_no;
                    $customer_license_exp_date=$customer->cust_license_issued_date;
                    $customer_passport=$customer->cust_passport_number;
                    $customer_passport_expiry="2022-11-11";//$customer->cust_passport_number;
                    //$customer_license_exp_date=$customer->cust_license_issued_date;
                    $city_qry=City::where('city_id',$bookingInfo->book_bill_cust_city)->first();
                    if($city_qry)
                    {
                        $city=$city_qry->city_name;
                    }
                    else
                    {
                        $city="";
                    }
                     $location_qry=City_location::where('city_loc_id',$bookingInfo->book_bill_cust_location)->first();
                    if($location_qry)
                    {
                        $location=$location_qry->location_name;
                    }
                    else
                    {
                        $location="";
                    }
                    //dd($location);
                    $country_qry=Country::where('country_id',$customer->cust_nationality)->first();
                    if($country_qry)
                    {
                        $country=$country_qry->country_name;
                        
                    }
                    
                    $client1 = new \GuzzleHttp\Client();
                if($customer->cust_qatar_id!=NULL)
                {
                    $id_no=$customer->cust_qatar_id;
                    
                }
                else
                {
                    $id_no=$customer_passport;
                    
                }
                $api = $client1->get('http://130.61.97.192:201/F_CUSTOMERS?LookupText='.$customer_first_name.'&PageSize=1&Skip=0&FC_MOBILE='.$customer->cust_mobile_number.'&FC_ID_NO='.$id_no);
                
                
                $dat= $api->getBody()->getContents();
                $response = json_decode($dat, true);
                if($response){
                    $respItems = $response['Items'];
                    //dd($respItems);
                }
               
               
                if(sizeof($respItems))
                {
                    $custCode = $response['Items']['0']['FC_CUST_NO'];
                    $customer->cust_code=$custCode;
                    $customer->update();
                    
                }
                else
                {
                    $custCode=null;
                    
                }
                    
                }
                else
                {
                    $customer_first_name="Not exist";
                    $customer_last_name="Not exist";
                    $customer_full_name='Not exist';
                    
                }
                $modal=Modal::where('modal_id',$bookingInfo->book_car_model)->first();
                if($modal)
                {
                    $model_number=(int)$modal->model_number;
                    $model_category=(int)$modal->modal_category;
                    $makerid=(int)$modal->makers;
                    $modelName = $modal->modal_name;
                    $makerName = $modal->maker['maker_name'];
                    
                    
                }
                else
                {
                     $model_number=0;
                    $model_category=0;
                    $makerid=0;
                    
                }
                
                
                //mail to customer 
               /*  $data = array('customer_fname'=>$customer_first_name,'customer_lname'=>$customer_last_name,
             'booking_ref_id'=>$ReferId,'booking_status'=>$statusName,'to_mail'=>$customer_email,'booking_from_date'=>$bookingInfo->book_from_date,'booking_to_date'=>$bookingInfo->book_to_date,'booking_pickup_time'=>$bookingInfo->book_pickup_time,'booking_return_time'=>$bookingInfo->book_return_time,'booking_total'=>$bookingInfo->book_total_rate,
            'booking_city_name'=>$city,'booking_model_name'=>$modelName,
             'booking_maker_name'=>$makerName,'booking_model_image'=>$bkmodelImage);
             //send mail to customer
            
             Mail::send('front-end/mail-templates/booking-template', $data, function($message) use ($data){
            $message->to($data['to_mail'],'Almana Leasing')->subject
                     ('BOOKING INFORMATION');
            $message->from('reservations@almanaleasing.com','ALMANA LEASING BOOKING INFORMATION');
             });
             
            Mail::send('front-end/mail-templates/booking-template', $data, function($message) use ($data){
            $message->to('info@almanaleasing.com','Almana Leasing')->subject
                     ('NEW BOOKING INFORMATION');
         $message->from('reservations@almanaleasing.com','ALMANA LEASING BOOKING INFORMATION');
              });*/
                
             
                
                $data['Booking_id'] = $currDetail;
                $data['Reference_id']   = $ReferId;
                $data['From_date'] =  $frmDate;
                $data['Pickup_Time'] = $pickupTime;
                $data['To_Date'] = $toDate;
                $data['Return_Time'] = $returnTime;
                $data['Daily_rate'] =  $request->input('book_daily_rate');
                $data['Total_rate'] = $request->input('book_total_rate');
                $data['Drop_fee']=  $request->input('drop_fee');
                $data['Country'] = $bookingInfo->country['country_name'];
                $data['City_Name'] = $bookingInfo->city['city_name'];
	    		$data['Location_Name'] = $bookingInfo->state['location_name'];
                $data['Additional_package'] = $request->input('additional_package');
                $data['Payment_session_id']  = $sessionid;
                $data['Payment_version']  = 57;
                $data['Payment_order_id'] = $orderid;
                $data['Booking_status'] = "Pending";
                $data['Payment_url']=$payUrl;
                $data['status']     = 1;
                $data['message']    = "Booking Awaiting Payment";
                return response($data);
                    
            }else{
                $data['errors'] = $validator->errors();
                $data['status'] = 0;
                $data['message'] = "Booking Failed";
            }
    	return response($data);
    }
    public function update(Request $request)
    {
        
    	$data = array();
        $frmDate = $request->input('book_from_date');
        // $countFromDate = Carbon::parse($fromDat); //for counting numbr of days 
        // $parseFromDate = Carbon::parse($fromDat)->format('Y-m-d');
        $toDate = $request->input('book_to_date');
        // $countToDt = Carbon::parse($toDat); //for counting number of days 
        // $parseToDt = Carbon::parse($toDat)->format('Y-m-d');
        $pickupTime = $request->input('book_pickup_time');
        // $parsePickTime = Carbon::parse($pickTime)->format('H:i:s'); //24 hours format
        $returnTime = $request->input('book_return_time');
        // $parseretnTime = Carbon::parse($retnTime)->format('H:i:s');
        $modelId = $request->input('book_car_model');
        $coupon_code=$request->coupon_code??NULL;
        
        $ftchMake = Modal::where('modal_id','=',$modelId)->first(); //get maker name 
        $makers = $ftchMake->maker->maker_name;
        
        $parseFrmDt = Helper::parseCarbon($frmDate); 
          $parseToDate = Helper::parseCarbon($toDate);
          $parsePickTime = Helper::parseCarbon($pickupTime);
          $parseRetTime = Helper::parseCarbon($returnTime);
          $diff = $parsePickTime->diffInHours($parseRetTime);
          $diffDays = $parseFrmDt->diffInDays($parseToDate);
          
          $combinedfrom = date('Y-m-d H:i:s', strtotime("$frmDate $pickupTime"));
          $combinedto = date('Y-m-d H:i:s', strtotime("$toDate $returnTime"));
          $parsecombinefrom = Helper::parseCarbon($combinedfrom); 
          $parsecombineto = Helper::parseCarbon($combinedto); 
          $diffDays2 = $parsecombinefrom->diffInDays($parsecombineto);
          $mins            = $parseRetTime->diffInMinutes($parsePickTime, true);
          $totMins = ($mins/60);
          
        
         
          //get number of days
          if($totMins > 4 && $diff <= 12  && $diffDays2 >= 1)
          {
             $days=$parseFrmDt->diffInDays($parseToDate)+1;  
          }else{
              $days=$parseFrmDt->diffInDays($parseToDate); 
          }
          
        // $days = $countFromDate->diffInDays($countToDt);
        
        $typoo = Helper::setType($days);
        $rateType = Mode_rate::where('rate_type_id','=',$typoo)->first();
        $fetchTypName = $rateType->rates->rate_type_code;
        $referIdCheck = Booking::latest('book_id')->first(); //check if any booking exist in tb and fetch its reference id
       $referIdCheck = Booking::latest('book_id')->first(); //check if any booking exist in tb and fetch its reference id
      $date = date('Ymd');
      $i=1;
      /*if(is_null($referIdCheck))
      {
          $num=rand(10,99);
         $ref_number = $date.$i;
      }
      else
      {
          $orderid  = $referIdCheck->book_ref_id;
         // dd($orderid);
          $orderdate = mb_substr($orderid, 0, 8);
          $ids = substr($orderid, 8);
          if($orderdate == $date){
              $ids++;
               $num=rand(10,99);
              $ref_number = $orderdate.$ids;
             // dd($app_number,"hii");
          }
          else{
               $num=rand(10,99);
              $ref_number = $date.$i;
            
          }  
      }*/
      $ReferId=$request->reference_number;
        $validator = Helper::validateBooking($request->all());
        
        if ($request->hasFile('book_file')) {
            $docFile = time() . '.' . $request->book_file->extension();
            $request->book_file->move('assets/uploads/booking', $docFile);
        }
        
        if(!$validator->fails())
            {
                $datas= $request->except('_token');
                //$currDetail = Booking::insertGetId($datas);
                
                Booking::where('book_ref_id','=',$ReferId)->update([
                    'book_from_date' => $parseFrmDt,
                    'book_to_date' => $parseToDate,
                    'book_file' => $docFile ?? '',
                    'book_pickup_time' => $parsePickTime,
                    'book_return_time' => $parseRetTime, 
                    'book_total_days' => $days,
                    'book_car_rate_type' => $fetchTypName,
                    'book_car_model'=>$request->input('book_car_model'),
                    'book_daily_rate'=>$request->input('book_daily_rate'),
                    'book_total_rate'=>$request->input('book_total_rate'),
                    'coupon_code'=>$coupon_code,
                    'book_bill_cust_city'=>$request->input('book_bill_cust_city'),
                    'book_bill_cust_state'=>$request->input('book_bill_cust_state'),
                    'book_bill_cust_location'=>$request->input('book_bill_cust_location'),
                    
                    // 'payment_status' =>1,
                    'active_flag' =>1,
                    'book_status' =>1,  //pending // it will become confirmed only wen payment is completed
                    'created_at' =>\Carbon\Carbon::now(),
                    'updated_at' =>\Carbon\Carbon::now()
                ]);
                //payment gateway 
                
                
                
                	$orderid= $this->generateRandomString(6);
	        $merchant="DB95927"; 
        	$apipassword="afbc40219aa0e4eb35e3ebfd46d809e8"; 
	        $amount=$request->input('book_total_rate');
	        $returnUrl = URL::to('booking-success');
	        $currency = "QAR";

	       /* $url = "https://dohabank.gateway.mastercard.com/api/rest/version/57/merchant/DB95927/session";
	
        	$ch = curl_init($url);
        	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        	curl_setopt($ch, CURLOPT_USERPWD, "merchant.DB95927:afbc40219aa0e4eb35e3ebfd46d809e8");
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        	$headers = array(
        	   "Authorization: Basic bWVyY2hhbnQuREI5NTkyNzphZmJjNDAyMTlhYTBlNGViMzVlM2ViZmQ0NmQ4MDllOA==",
        	   "Content-Type: application/json",
        	);
	
	
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data1 = <<<DATA
{

    "apiOperation": "CREATE_CHECKOUT_SESSION",

    "interaction": {

        "operation": "PURCHASE"

    },

    "order"      : {

        "amount"     : "$amount",

        "currency"   : "$currency",

        "description": "Car Booking",

        "id": "$orderid"

    }

}
DATA;


curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);

//for debug only!
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($ch);

$response = json_decode($resp);


// exit;
curl_close($ch);

$sessionid = $response->session->id;*/
$sessionid=rand(1000,9999);

                Booking::where('book_ref_id','=',$ReferId)->update([
                    'book_ref_id' => $ReferId,
                    'payment_session_id' => null
                ]);

                
                //payment gateway end
                $bookingInfo = Booking::where('book_ref_id','=',$ReferId)->first();
                if($coupon_code!=NULL)
                {
                    $cust_id=$bookingInfo->book_cust_id;
                    $coupon=Coupon::where('coupon_code',$coupon_code)->first();
                    if($coupon)
                    {
                    $customer_coupon=CustomerCoupon::where('customer_id',$cust_id)->where('coupon_id',@$coupon->id)->first();
                    $customer_coupon->is_applied=1;
                    $customer_coupon->update();
                    
                    }
                    
            
            
                }
       if($coupon_code!=NULL)
        {
            $coupon_discount=($request->input('book_daily_rate')*$days)-$request->input('book_total_rate');
            
        }
        else
        {
            $coupon_discount=0;
            
        }
        
            //save notification
            $statusName = "Under Process";
            $notfContent = "Your Booking with Reference Number: " . $ReferId . " is " . $statusName;
            Notification::create([
                    'customer_id' => $bookingInfo->book_cust_id,
                    'notification_title' => "Booking Status",
                    'notification_content' => $notfContent,
                    'notification_status' => 1
                ]);
                
                
                 //push notification
            $devices = Device::where('customer_id', $bookingInfo->book_cust_id)->get();

            foreach ($devices as $device) {
                $notification = [];
                $title = "Booking Success";
                $body = "Booking with booking id " . $ReferId . " has been updated successfully";
                $clickAction = "ReservationFragment";
                $type = "Booking";
                $notification[] = Helper::customerNotification($device->device_token, $title, $body, $clickAction, $type);
                $data['notification'] = $notification;
            }
             $customer=Customer::where('customer_id','=',$bookingInfo->book_cust_id)->first();
               if($customer!=NULL)
                {
                    
                    $statusName = "Under Process";
                     $bkmodelImage = $bookingInfo->model->modelImage->model_image;

                    
             
                    $customer_first_name=$customer->cust_fname;
                    $customer_last_name=$customer->cust_lname;
                    $customer_full_name=$customer->fname.''.$customer->cust_lname;
                    $customer_dob=$customer->cust_dob;
                    $customer_email=$customer->email;
                    $customer_address=$bookingInfo->book_bill_cust_address_1.' '.$bookingInfo->book_bill_cust_address_2;
                    $customer_license_no=$customer->cust_driving_license_no;
                    $customer_license_exp_date=$customer->cust_license_issued_date;
                    $customer_passport=$customer->cust_passport_number;
                    $customer_passport_expiry="2022-11-11";//$customer->cust_passport_number;
                    //$customer_license_exp_date=$customer->cust_license_issued_date;
                    $city_qry=City::where('city_id',$bookingInfo->book_bill_cust_city)->first();
                    if($city_qry)
                    {
                        $city=$city_qry->city_name;
                    }
                    else
                    {
                        $city="";
                    }
                     $location_qry=City_location::where('city_loc_id',$bookingInfo->book_bill_cust_location)->first();
                    if($location_qry)
                    {
                        $location=$location_qry->location_name;
                    }
                    else
                    {
                        $location="";
                    }
                    //dd($location);
                    $country_qry=Country::where('country_id',$customer->cust_nationality)->first();
                    if($country_qry)
                    {
                        $country=$country_qry->country_name;
                        
                    }
                    
                    $client1 = new \GuzzleHttp\Client();
                if($customer->cust_qatar_id!=NULL)
                {
                    $id_no=$customer->cust_qatar_id;
                    
                }
                else
                {
                    $id_no=$customer_passport;
                    
                }
                $api = $client1->get('http://130.61.97.192:201/F_CUSTOMERS?LookupText='.$customer_first_name.'&PageSize=1&Skip=0&FC_MOBILE='.$customer->cust_mobile_number.'&FC_ID_NO='.$id_no);
                
                
                $dat= $api->getBody()->getContents();
                $response = json_decode($dat, true);
                if($response){
                    $respItems = $response['Items'];
                    //dd($respItems);
                }
               
               
                if(sizeof($respItems))
                {
                    $custCode = $response['Items']['0']['FC_CUST_NO'];
                    $customer->cust_code=$custCode;
                    $customer->update();
                    
                }
                else
                {
                    $custCode=null;
                    
                }
                    
                }
                else
                {
                    $customer_first_name="Not exist";
                    $customer_last_name="Not exist";
                    $customer_full_name='Not exist';
                    
                }
                $modal=Modal::where('modal_id',$bookingInfo->book_car_model)->first();
                if($modal)
                {
                    $model_number=(int)$modal->model_number;
                    $model_category=(int)$modal->modal_category;
                    $makerid=(int)$modal->makers;
                    $modelName = $modal->modal_name;
                    $makerName = $modal->maker['maker_name'];
                    
                    
                }
                else
                {
                     $model_number=0;
                    $model_category=0;
                    $makerid=0;
                    
                }
                
                
                //mail to customer 
                 $data = array('customer_fname'=>$customer_first_name,'customer_lname'=>$customer_last_name,
             'booking_ref_id'=>$ReferId,'booking_status'=>$statusName,'to_mail'=>$customer_email,'booking_from_date'=>$bookingInfo->book_from_date,'booking_to_date'=>$bookingInfo->book_to_date,'booking_pickup_time'=>$bookingInfo->book_pickup_time,'booking_return_time'=>$bookingInfo->book_return_time,'booking_total'=>$bookingInfo->book_total_rate,
            'booking_city_name'=>$city,'booking_model_name'=>$modelName,
             'booking_maker_name'=>$makerName,'booking_model_image'=>$bkmodelImage);
             //send mail to customer
            
             Mail::send('front-end/mail-templates/booking-template', $data, function($message) use ($data){
            $message->to($data['to_mail'],'Almana Leasing')->subject
                     ('BOOKING INFORMATION');
            $message->cc('info@almanaleasing.com', 'Almana Leasing');
            $message->from('reservations@almanaleasing.com','ALMANA LEASING BOOKING INFORMATION');
             });
             
             //mail to reservation mail of almana
             
        //      Mail::send('front-end/mail-templates/booking-template', $data, function($message) use ($data){
        //     $message->to('info@almanaleasing.com','Almana Leasing')->subject
        //              ('NEW BOOKING INFORMATION');
        //  $message->from('reservations@almanaleasing.com','ALMANA LEASING BOOKING INFORMATION');
        //       });
                
             
                
                $data['Booking_id'] = $bookingInfo->book_id;
                $data['Reference_id']   = $ReferId;
                $data['From_date'] =  $frmDate;
                $data['Pickup_Time'] = $pickupTime;
                $data['To_Date'] = $toDate;
                $data['Return_Time'] = $returnTime;
                $data['Daily_rate'] =  $request->input('book_daily_rate');
                $data['Total_rate'] = $request->input('book_total_rate');
                $data['Drop_fee']=  $request->input('drop_fee');
                $data['Country'] = $bookingInfo->country['country_name'];
                $data['City_Name'] = $bookingInfo->city['city_name'];
	    		$data['Location_Name'] = $bookingInfo->state['location_name'];
                $data['Additional_package'] = $request->input('additional_package');
                $data['Payment_session_id']  = $sessionid;
                $data['Payment_version']  = 57;
                $data['Payment_order_id'] = $orderid;
                $data['Booking_status'] = "Pending";
                $data['status']     = 1;
                $data['message']    = "Booking Success";
                return response($data);
                    
            }else{
                $data['errors'] = $validator->errors();
                $data['status'] = 0;
                $data['message'] = "Booking Failed";
            }
    	return response($data);
    }
    
    public function bookingSuccess(Request $request)
    {
        
        $data = array();
        $bookDetails = array();
        try {
            $referenceId = $request->booking_ref_id;
            //$orderId = $request->order_id;
            $sessionId = $request->session_id;
            if($sessionId!="")
            {
           
            $getBookInfo = Booking::where('book_ref_id','=',$referenceId)->first();
            if($getBookInfo)
            {
                if($getBookInfo->coupon_code!=NULL)
        {
            $coupon_discount=($getBookInfo->book_daily_rate*$getBookInfo->book_total_days)-$getBookInfo->book_total_rate;
            
        }
        else
        {
            $coupon_discount=0;
            
        }
               Booking::where('book_ref_id','=',$referenceId)->update([
                'book_status' =>1, //confirmed status changed upon client request. if payment is success also default status needs to be pending/underprocess
                'coupon_discount'=>$coupon_discount
                ]); 
                $data['Booking_status']  = "Confirmed";
                $data['Booking_status_code']  = "4";
                $data['message'] = "Payment Success";
                $data['status'] = 1;
                $modelInfo = Modal::where('modal_id','=',$getBookInfo->book_car_model)->first();
                $model = array();
                    $model['Model_id']   = $getBookInfo->book_car_model;
                    $model['Model_name']   = $modelInfo->modal_name;
                    $model['Maker']   = $modelInfo->maker['maker_name'];
                    $model['Model_category'] = $modelInfo->category['model_cat_name'];
                    //specifications
                    $resSpec = Model_specification::where('model_id','=',$modelInfo->modal_id)->get();
                    $spec=array();
                  foreach ($resSpec as $resSpecs) {
                    $specComb[0] = $resSpecs->specs['spec_name'];
                    $specComb[1] = '/assets/uploads/specifications/icons/'.$resSpecs->specs['spec_icon'];
                    array_push($spec,$specComb);

                  }
                  
                  $model['specifications'] = $spec;
                   
             $customer=Customer::where('customer_id','=',$getBookInfo->book_cust_id)->first();
               if($customer!=NULL)
                {
                    $customer_first_name=$customer->cust_fname;
                    $customer_last_name=$customer->cust_lname;
                    $customer_full_name=$customer->fname.''.$customer->cust_lname;
                    $customer_dob=$customer->cust_dob;
                    $customer_email=$customer->email;
                    $customer_address=$customer->cust_address_line_1.' '.$customer->cust_address_line_2;
                    $customer_license_no=$customer->cust_driving_license_no;
                    $customer_license_exp_date=$customer->cust_license_issued_date;
                    $customer_passport=$customer->cust_passport_number;
                    $customer_passport_expiry="2022-11-11";//$customer->cust_passport_number;
                    //$customer_license_exp_date=$customer->cust_license_issued_date;
                    $city_qry=City::where('city_id',$getBookInfo->book_bill_cust_city)->first();
                    if($city_qry)
                    {
                        $city=$city_qry->city_name;
                    }
                    else
                    {
                        $city="";
                    }
                     $location_qry=City_location::where('city_loc_id',$getBookInfo->book_bill_cust_location)->first();
                    if($location_qry)
                    {
                        $location=$location_qry->location_name;
                    }
                    else
                    {
                        $location="";
                    }
                    //dd($location);
                    $country_qry=Country::where('country_id',$customer->cust_nationality)->first();
                    if($country_qry)
                    {
                        $country=$country_qry->country_name;
                        
                    }
                    
                    $client1 = new \GuzzleHttp\Client();
                if($customer->cust_qatar_id!=NULL)
                {
                    $id_no=$customer->cust_qatar_id;
                    
                }
                else
                {
                    $id_no=$customer_passport;
                    
                }
                $api = $client1->get('http://130.61.97.192:201/F_CUSTOMERS?LookupText='.$customer_first_name.'&PageSize=1&Skip=0&FC_MOBILE='.$customer->cust_mobile_number.'&FC_ID_NO='.$id_no);
                
                
                $dat= $api->getBody()->getContents();
                $response = json_decode($dat, true);
                if($response){
                    $respItems = $response['Items'];
                    //dd($respItems);
                }
               
               
                if(sizeof($respItems))
                {
                    $custCode = $response['Items']['0']['FC_CUST_NO'];
                    $customer->cust_code=$custCode;
                    $customer->update();
                    
                }
                else
                {
                    $custCode=null;
                    
                }
                    
                }
                else
                {
                    $customer_first_name="Not exist";
                    $customer_last_name="Not exist";
                    $customer_full_name='Not exist';
                    
                }
                $modal=Modal::where('modal_id',$getBookInfo->book_car_model)->first();
                if($modal)
                {
                    $model_number=(int)$modal->model_number;
                    $model_category=(int)$modal->modal_category;
                    $makerid=(int)$modal->makers;
                    
                    
                }
                else
                {
                     $model_number=0;
                    $model_category=0;
                    $makerid=0;
                    
                }
                
               /*  $client2 = new \GuzzleHttp\Client();
                        $api2 =   $client2->post('http://130.61.97.192:201/Reservation',
                        array(
                            'form_params' => 
                            array(
                               
                              "rsr_book_date"=>date('Y-m-d',strtotime($getBookInfo->created_at))??"2022-10-29",  

                            
                              "rsr_cust_name"=>$customer_full_name, 
                              
                              "rsr_cust_cat_code"=>"test", 
                              "rsr_cust_code"=>$custCode, 
                              
                              "rsr_cust_gender"=>"",
                            
                              "rsr_cust_addr"=>$customer_address,  
                              'rsr_cust_dob'=>$customer_dob,
                              
                              "rsr_cust_cat_code "=>"NA",
                              
                              'rsr_customer_passport'=>$customer_passport,
                              
                              'rsr_customer_passport_exp'=>$customer_passport_expiry,
                              
                              'rsr_rent_start_date'=>date('Y-m-d',strtotime($getBookInfo->book_from_date)),
                              
                              'rsr_rent_start_time'=>date('H:i',strtotime($getBookInfo->book_pickup_time)),
                              
                              'rsr_rent_end_date'=>date('Y-m-d',strtotime($getBookInfo->book_to_date)),
                              
                              'rsr_rent_end_time'=>date('H:i',strtotime($getBookInfo->book_return_time)),
                              
                              'rsr_cust_qid'=>$customer->cust_qatar_id,
                              
                              'rsr_cust_qid_exp'=>"2022-11-07",
                              
                              'rsr_rental_days'=>@$getBookInfo->book_total_days,
                              
                              'rsr_rental_amount'=>@$getBookInfo->book_total_rate,
                              
                              'rsr_pickup_location'=>$location,
                            
                              "rsr_tel"=>$customer->cust_mobile_number,          
                            
                              "rsr_email"=>$customer_email,        
                            
                              "rsr_nation"=>$country,      
                            
                              "rsr_cust_id"=>1,
                              
                              "rsr_cust_id_exp"=>"2022-10-29",
                              
                             
                              
                              "rsr_driving_lic_no"=>$customer_license_no,
                              
                              "rsr_driving_lic_exp"=>$customer_license_exp_date??"2022-10-29",
                              
                              "rsr_coupon_code"=>$getBookInfo->coupon_code??'',
                              
                              "rsr_coupon_disc"=>$coupon_discount,
                              
                              "rsr_act_flag"=>'A',
                            
                              "rsr_rent_date"=>$getBookInfo->book_from_date??"2022-10-29",    
                            
                              "rsr_rent_time"=>date('H:i',strtotime($getBookInfo->book_pickup_time))??"11:30",    
                            
                              "rsr_car_group"=>1,    
                            
                              "rsr_car_make"=>$makerid,    
                            
                              "rsr_car_model"=>$model_number,    
                            
                              "rsr_rent_type"=>'D' ,   
                            
                              "rsr_rent_rate"=>$getBookInfo->book_daily_rate,  
                              
                              'rsr_cust_category'=>1,
                            
                              "rsr_website_booking_ref"=>$referenceId
                            )
                        )
                    );*/
                     //mail to customer 
                 $data = array('customer_fname'=>$customer_first_name,'customer_lname'=>$customer_last_name,
             'booking_ref_id'=>$ReferId,'booking_status'=>$statusName,'to_mail'=>$customer_email,'booking_from_date'=>$getbookInfo->book_from_date,'booking_to_date'=>$getbookInfo->book_to_date,'booking_pickup_time'=>$getbookInfo->book_pickup_time,'booking_return_time'=>$getbookInfo->book_return_time,'booking_total'=>$getbookInfo->book_total_rate,
            'booking_city_name'=>$city,'booking_model_name'=>$modelName,
             'booking_maker_name'=>$makerName,'booking_model_image'=>$bkmodelImage);
             //send mail to customer
            
             Mail::send('front-end/mail-templates/booking-template', $data, function($message) use ($data){
            $message->to($data['to_mail'],'Almana Leasing')->subject
                     ('BOOKING INFORMATION');
            $message->from('reservations@almanaleasing.com','ALMANA LEASING BOOKING INFORMATION');
             });
             
             //mail to reservation mail of almana
             
             Mail::send('front-end/mail-templates/booking-template', $data, function($message) use ($data){
            $message->to('info@almanaleasing.com','Almana Leasing')->subject
                     ('NEW BOOKING INFORMATION');
         $message->from('reservations@almanaleasing.com','ALMANA LEASING BOOKING INFORMATION');
              });
                
                
                    $data['Reference_id']   = $getBookInfo->book_ref_id;
                    $data['From_date'] =  $getBookInfo->book_from_date;
                    $data['Pickup_Time'] = $getBookInfo->book_pickup_time->format('H:i:s');
                    $data['To_Date'] = $getBookInfo->book_to_date;
                    $data['Return_Time'] = $getBookInfo->book_return_time->format('H:i:s');
                    $data['Daily_rate'] =  $getBookInfo->book_daily_rate;
                    $data['Total_rate'] = $getBookInfo->book_total_rate;
                    $data['Drop_fee']=  $getBookInfo->drop_fee;
                    $data['Country'] = $getBookInfo->country['country_name'];
                    $data['City_Name'] = $getBookInfo->city['city_name'];
    	    		$data['Location_Name'] = $getBookInfo->state['location_name'];
                    $data['Additional_package'] = $getBookInfo->additional_package;
                    array_push($bookDetails,$model);
                     $data['Models'] = $bookDetails;
                
            }else{
                $data['Booking_status']  = "Pending";
                $data['message'] = "Reference Id/sessionId Does not Exist";
                $data['status'] = 0;
            }
            }else{
                $data['Booking_status']  = "Pending";
                $data['message'] = "No Session Id Recieved";
                $data['status'] = 0;
                
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
    
    
    public function paymentCancel(Request $request)
    {
        $data = array();
        try {
            $referenceId = $request->booking_ref_id;
            //$orderId = $request->order_id;
            $sessionId = $request->session_id;
            if($sessionId!="")
            {
            $getBookInfo = Booking::where('book_ref_id','=',$referenceId)->first();
            if($getBookInfo)
            {
               Booking::where('book_ref_id','=',$referenceId)->update([
                'book_status' =>3, //payment failed
                ]); 
                $data['Booking_status']  = "Payment Failed";
                $data['Booking_status_code']  = "3";
                $data['status'] = 1;
                $data['message'] = "Payment Failed";
            }else{
                $data['Booking_status']  = "Pending";
                $data['status'] = 0;
                $data['message'] = "Reference Id/sessionId Does not Exist";
            }
            }else{
                $data['Booking_status']  = "Pending";
                $data['status'] = 0;
                $data['message'] = "No Session Id Recieved";
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
    
    
    public function cancelBooking(Request $request)
    {
        $data = array();
        try {

            $BookingNumber = $request->booking_number;
            $CustomerId = $request->customer_id;

            //check if customer with such a booking exist
            $custCheck = Booking::where('book_cust_id','=',$CustomerId)->where('book_ref_id',$BookingNumber)->first();

            if($custCheck)
            {
                $curDate = \Carbon\Carbon::now();
                $cretdAt = $custCheck->created_at;
                $addDayss = $cretdAt->addDays(1);

            if($curDate<=$addDayss)
            {
                Booking::where('book_ref_id','=',$BookingNumber)->update([
                        'book_status' => 5,
                        'active_flag' => 0

                    ]);
               $data['status'] = 1;
               $data['Booking_status'] = "Cancelled";
               $data['is_Active '] = 0;
               $data['message'] = "Booking for Reference id ". $BookingNumber . " is Cancelled.";
               
                }else{
                     
                    $data['status'] = 0;
                    $data['message'] = "Time Exceeded. Unable to cancel Booking";
                }

            }else{
                $data['status'] = 0;
                $data['message'] = "No Such Booking Exist for the Customer";
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
    
     public function bookAgainInfo(Request $request)
    {

        $data = array();
        $model = array();
        $customer = array();
        try {

                $customerId = $request->customer_id;
                $bookingRefId = $request->booking_reference_id;
                $frmDate = $request->from_date;
                $toDate = $request->to_date;
                $parseFrmDt = Helper::parseCarbon($frmDate); 
             $parseToDate = Helper::parseCarbon($toDate);
              $frmDt = $parseFrmDt->format('Y-m-d');
              $toDt = $parseToDate->format('Y-m-d');
              $secndParsFrm =Helper::parseCarbon($frmDt);
              $secndParseTo = Helper::parseCarbon($toDt);
            $pickTime = $parseFrmDt->format('H:i:s');
            $retTime = $parseToDate->format('H:i:s');
            $parsePickTime = Helper::parseCarbon($pickTime);
            $parseRetTime = Helper::parseCarbon($retTime);
            $diff = $parsePickTime->diffInHours($parseRetTime);
          $diffDays2 = $parseFrmDt->diffInDays($parseToDate);
          $mins            = $parseRetTime->diffInMinutes($parsePickTime, true);
          $totMins = ($mins/60);
                // $pickupTime = $request->input('pickup_time');
                // $returnTime = $request->input('return_time');
                $curType = $request->currency_id;

                $fetchPrvBooking = Booking::where('book_ref_id','=',$bookingRefId)->first();
                

                $modalId = $fetchPrvBooking->book_car_model;
               
                $locId = $request->city_loc_id??$fetchPrvBooking->book_bill_cust_location;
                $cityId = $request->city_id??$fetchPrvBooking->book_bill_cust_city;
                $resCity =City::where('city_id','=',$cityId)->first(); //Get City
                $resLoc = City_location::where('city_loc_id','=',$locId)->first(); //Get Location
                $fetchCust = Customer::where('customer_id','=',$fetchPrvBooking->book_cust_id)->first();

                //customer info
                $customer['First_name'] = $fetchPrvBooking->book_bill_cust_fname;
                $customer['Last_name'] = $fetchPrvBooking->book_bill_cust_lname;
                $customer['Date_of_Birth'] = $fetchPrvBooking->book_bill_cust_dob;
                $customer['From_Date'] = $frmDt;
                $customer['To_Date'] = $toDt;
                $customer['Pickup_Time'] = $pickTime;
                $customer['Return_Time'] = $retTime;
                $customer['Customer_Id'] = $fetchPrvBooking->book_cust_id;
                $customer['Mobile_code'] = $fetchPrvBooking->book_bill_cust_mobile_code;
                $customer['Mobile_Number'] = $fetchPrvBooking->book_bill_cust_mobile;
                $customer['Qatar Id'] = $fetchPrvBooking->book_bill_cust_qatar_id;
                $customer['Country'] = $fetchPrvBooking->book_bill_cust_nationality;
                $customer['Address_1'] = $fetchPrvBooking->book_bill_cust_address_1;
                $customer['Address_2'] = $fetchPrvBooking->book_bill_cust_address_2;
                $customer['Zipcode'] = $fetchPrvBooking->book_bill_cust_zipcode;
                $customer['Location'] = $resLoc->location_name;
                $customer['Location_Arb'] = @$resLoc->ar_location_name;
                $customer['location_id']=(int)$locId;
                $customer['City'] = $resCity->city_name;
                $customer['City_Arb'] = @$resCity->ar_city_name;
                $customer['city_id']=(int)$cityId;
                if($fetchCust)
                {
                $customer['License_number']  = @$fetchCust->cust_driving_license_no??'';
                $customer['License_date']  = @$fetchCust->cust_license_issued_date??'' ;
                $customer['License_country']  = @$fetchCust->cust_license_issued_country??'' ;
                $customer['License_country_name']  = @$fetchCust->licenseCountry['country_name'];
                $customer['Billing_country_id'] = $fetchCust->cust_bill_country;
                $customer['Billing_country'] = @$fetchCust->billcountry['country_name'];
                $customer['Address_line_1'] = $request->cust_address_line_1??$fetchCust->cust_address_line_1;
                $customer['Address_line_2'] =$request->cust_address_line_2?? $fetchCust->cust_address_line_2;
                    
                }
                else
                {
                $customer['License_number']  = '';
                $customer['License_date']  = '' ;
                $customer['License_country']  = '' ;
                $customer['License_country_name']  = '';
                $customer['Billing_country_id'] = '';
                $customer['Billing_country'] = '';
                 $customer['Address_line_1'] = $request->cust_address_line_1;
                $customer['Address_line_2'] =$request->cust_address_line_2;
                    
                }
                


                //model details
 

             
          
          //get number of days
          if($totMins > 4 && $diff <= 12  && $diffDays2 >= 1)
          {
            $days=$secndParsFrm->diffInDays($secndParseTo)+1;  
          }else{
            $days=$secndParsFrm->diffInDays($secndParseTo); 
          } 
            //   $days=$parseFrmDt->diffInDays($parseToDate); 
              $data['Days'] = $days;
              $data['City'] = $resCity->city_name;
              $data['Location'] = $resLoc->location_name;

            if(!$days==0)
            {
              $modList= Modal::where('modal_id','=',$modalId)->where('active_flag','=',1)->first();
              $car=array();

                    $modalId = $modList->modal_id;
                    $car['Model_Id'] = $modalId;
                    $car['Model_name']=$modList->modal_name;
                    $car['Maker']=$modList->maker->maker_name;
                    $data['Model_category'] = $modList->category->model_cat_name;
                    $data['Model_Available'] = $modList->rdy_count;
                    $modImage = Model_image::where('model_id',$modList->modal_id)->where('model_image_flag','=',0)->first();
                    $car['Model_image'] = '/assets/uploads/models/'.$modImage->model_image;
                    //specifications
                    $resSpec = Model_specification::where('model_id','=',$modList->modal_id)->get();
                    $spec=array();
                      foreach ($resSpec as $resSpecs) {
                        $specComb[0] = @$resSpecs->specs['spec_name'];
                        $specComb[1] = '/assets/uploads/specifications/icons/'.@$resSpecs->specs['spec_icon'];
                        $specComb[2] = @$resSpecs->specs['ar_spec_name'];
                        array_push($spec,$specComb);

                      }
                      $car['specifications'] = $spec;
                      $typoo = Helper::setType($days);
                      //return $typoo;
                       if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->model_number)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->model_number)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }
               
                   foreach ($rateType as $rateTypes) {
                    
                      $fetchrate = $rateTypes->rate; //get rate from the table //rate
                      $fetchOfferRate =Helper::checkOffer($rateTypes->model_rate_id,$modList->modal_id); //get offer rate from table
                      if($curType)
                       {
                          $fetchCurrency = Currency::where('currency_id','=',$curType)->first();
                          $car['Currency_code'] = $fetchCurrency->currency_code;
                          $curConvertRate = $fetchCurrency->currency_conversion_rate;

                          $mainOffer = $fetchOfferRate*$curConvertRate;
                          $mainRat = $fetchrate*$curConvertRate;

                          if($fetchOfferRate<$fetchrate)
                          {
                            $rate = $fetchOfferRate*$curConvertRate;
                          }else{
                            $rate = $fetchrate*$curConvertRate;
                          }
                        }
                       $car['Rate_code'] = $rateTypes->rates->rate_type_code;
                       // $car['Total_Rate'] = Helper::showList($days,$rate);
                        $rt = Helper::showList($days,$rate);

                       $car['Total_Rate'] = floatval($rt['totValue']);
                       $car['model_year']=@$rateTypes->model_year;

                       $car['Rate_per_day'] = floatval(number_format($rt['perDayRate'], 3, '.', ''));
                       //var_dump($car['Rate_per_day']);
                       $car['Main_Rate']= $mainRat;
                       $car['Offer_Rate'] = $mainOffer;
                       
                     array_push($model,$car); 
                   
                     }
                     $data['status'] = 1;
                     $data['message'] = "success";
                     $data['currency']="QAR";
                     $data['city_id']=(int)$cityId;
                      $data['location_id']=(int)$locId;
                      $data['country_id']=(int)$request->country_id;
                     $data['Customer_Info'] = $customer;
                    $data['Model_Info'] = $model;

                     }else{
              $data['status'] = 0;
              $data['message'] = "No Cars available";
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

    
     public function ViewEachBook(Request $request)
    {
       

         $data = array();
        try {

            $customerId = $request->customer_id;
            $bookingRefId = $request->booking_reference_id;

            //check if customer with such a booking exist
            $custCheck = Booking::where('book_cust_id','=',$customerId)->where('book_ref_id',$bookingRefId)->first();

            if($custCheck)
            {
                $data['status'] = 1;
                $data['Reference_id'] = $custCheck->book_ref_id;
                $data['Pickup_Date'] = $custCheck->book_from_date;
                $data['Return_Date'] = $custCheck->book_to_date;

                $data['Total_Days'] = $custCheck->book_total_days;

                $data['Rate_Per_Day'] = $custCheck->book_daily_rate;

                $data['Total_Rate'] = $custCheck->book_total_rate;
                $data['Customer_First_Name '] = $custCheck->book_bill_cust_fname;
                $data['Customer_Last_Name'] = $custCheck->book_bill_cust_lname;
                $data['Customer_Date_of_Birth'] = $custCheck->customer['cust_dob'];
                $data['Mobile_Number'] = $custCheck->customer['cust_mobile_number'];
                $data['Qatar_ID'] = $custCheck->customer['cust_qatar_id'];
                $data['Nationality'] = $custCheck->country['country_name'];
                $data['City'] = $custCheck->city['city_name'];
                $data['Location'] = $custCheck->state['location_name'];
                $data['Address_1'] = $custCheck->book_bill_cust_address_1;
                $data['Address_2'] = $custCheck->book_bill_cust_address_2;
                $data['Zipcode'] = $custCheck->book_bill_cust_zipcode;




            }else{
                $data['status'] = 0;
                $data['message'] = "No Such Booking Exist for the Customer";
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
    
     public  function generateRandomString($length = 6) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function termsConditions()
    {
        $data = array();
        try {
            
            $getData = Setting::where('id','=',1)->first();
            $data['status'] = 1;
            $data['message'] = "success";
            $data['Terms_and_conditions_Line_1'] = $getData->st_description;
            $data['Terms_and_conditions_Line_2'] = $getData->st_description_line_2;
        return response($data);

        }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];

            return response($response);
        }
    }
    
    public function additionaInfo()
    {
        $data = array();
        try {
            
            $getData = Setting::where('id','=',2)->first();
            $data['status'] = 1;
            $data['message'] = "success";
            $data['Additional_info_Line_1'] = $getData->st_description;
            $data['Additional_info_Line_2'] = $getData->st_description_line_2;
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
