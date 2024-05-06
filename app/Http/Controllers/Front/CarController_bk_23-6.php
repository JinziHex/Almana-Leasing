<?php

namespace App\Http\Controllers\Front;

use App\Coupon;
use App\CustomerCoupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modal;
use App\Models\Maker;
use App\Models\Currency;
use App\Models\Booking;
use App\Models\Model_category;
use App\Models\Rate_type;
use App\Models\Mode_rate;
use App\Models\Model_image;
use App\Models\City;
use App\Models\Setting;
use App\Models\Model_specification;
use App\Models\City_location;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Crypt;
use Session;
use App\Helpers\Helper;
use App\Models\Promotion;
use Auth;
use  Carbon\Carbon;
use Illuminate\Contracts\Session\Session as SessionSession;
use Validator;
use Illuminate\Support\Facades\URL;
use Mail;



class CarController extends Controller
{
    
    public function payment()
    {
        
	$orderid= "258745";
	$merchant="DB95927"; 
	$apipassword="afbc40219aa0e4eb35e3ebfd46d809e8"; 
	$amount="1";
	$returnUrl = URL::to('booking-success');
	$currency = "QAR";

	$url = "https://dohabank.gateway.mastercard.com/api/rest/version/57/merchant/DB95927/session";
	
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

$data = <<<DATA
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


curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

//for debug only!
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($ch);

$response = json_decode($resp);

// exit;
curl_close($ch);

$sessionid = $response->session->id;

return view('front-end.elements.payment.payment-connect',compact('response','sessionid','amount','currency','orderid'));

        // $endpoint = "https://dohabank.gateway.mastercard.com/api/rest/version/57/merchant/DB95927/session";
        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('POST', $endpoint,  [
        //     'apiOperation' => 'CREATE_CHECKOUT_SESSION', 
        //     // 'apiPassword' => "afbc40219aa0e4eb35e3ebfd46d809e8",
        //     // 'apiUsername'=>"merchant.DB95927",
        //     // 'merchant'=>"DB95927",
        //     'interaction["operation"]' => 'PURCHASE',
        //     'order["id"]' => "46456456",
        //     'order["amount"]'=>"100.00",
        //     'order["currency"]'=> "QAR",
        //     'allow_redirects' => false,
        //       'verify'          => false,
        //       'debug' => true
        // ]);
        
        // $statusCode = $response->getStatusCode();
        // $content = $response->getBody()->getContents();
        // print_r($content);
        
       


  }
    public function carList()
    {
     
    	$fetcCurrency = Currency::orderBy('currency_id','DESC')->get();
    	$vehicleType = Model_category::orderBy('model_cat_id','DESC')->get();
    	$fetchModels = Modal::orderBy('modal_id','DESC')->get();
    	return view('front-end.elements.car.list',compact('fetcCurrency','vehicleType','fetchModels'));
    }

    public function searchCar(Request $request, $id=NULL,$bid=NULL, $cid=1, $filter=NULL)
    {

      $id = $request->id;
      $bid = $request->bid;
      //dd(Helper::checkOffer(56,17));
      if(Session::has('cur_type'))
      {    
        $fetcCurrency = Currency::orderBy('currency_id','DESC')->get();
        $fetchCity = City::orderBy('city_id','DESC')->get();
        $vehicleType = Model_category::orderBy('model_cat_id','DESC')->get();
        $vehicleMaker = Maker::where('maker_name','!=','Not Defined')->orderBy('maker_id','DESC')->get();
        $data = array();
        $model = array();
  
      if(!Session::has('location'))
      {
          $locId = $request->input('city_loc_id');
          $cityId = $request->input('city_id');
          $frmDate = $request->input('from_date');
          $toDate = $request->input('to_date');
          $pickupTime = $request->input('pickup_time');
          $returnTime = $request->input('return_time');
          $curType = Session::get('cur_type');
          Session::put('location',$locId);
          Session::put('city',$cityId);
          Session::put('fromdate',$frmDate);
          Session::put('todate',$toDate);
          Session::put('pickupTime',$pickupTime);
          Session::put('returnTime',$returnTime);
          Session::put('currency_type',$curType);

      }else{
          $locId = Session::get('location');
          $cityId = Session::get('city');
          $frmDate =Session::get('fromdate');
          $toDate = Session::get('todate');
          $pickupTime = Session::get('pickupTime');
          $returnTime = Session::get('returnTime');
          $curType = Session::get('currency_type'); 
          
      }


          $resCity =City::where('city_id','=',$cityId)->first(); //Get City
          $resLoc = City_location::where('city_loc_id','=',$locId)->first(); //Get Location
          $parseFrmDt = Helper::parseCarbon($frmDate); //parse from date to carbon format
          $parseToDate = Helper::parseCarbon($toDate); //parse to date to carbon format
          $parsePickTime = Helper::parseCarbon($pickupTime); //parse picktime to carbon format
          $parseRetTime = Helper::parseCarbon($returnTime); //parse returntime to carbon format
          $diff = $parsePickTime->diffInHours($parseRetTime); //find hour difference based on time
          $diffDays = $parseFrmDt->diffInDays($parseToDate); //find days difference based on date
          //calculate the difference w.r.t to time
          $combinedfrom = date('Y-m-d H:i:s', strtotime("$frmDate $pickupTime"));
          $combinedto = date('Y-m-d H:i:s', strtotime("$toDate $returnTime"));
          $parsecombinefrom = Helper::parseCarbon($combinedfrom); 
          $parsecombineto = Helper::parseCarbon($combinedto); 
          $diffDays2 = $parsecombinefrom->diffInDays($parsecombineto);
          $mins            = $parseRetTime->diffInMinutes($parsePickTime, true);
          $totMins = ($mins/60);
          
          //get number of days
          if($totMins > 3 && $diff <= 12  && $diffDays2 >= 1)
          {
                $days=$parseFrmDt->diffInDays($parseToDate)+1; 
            
          }else{
             $days=$parseFrmDt->diffInDays($parseToDate); 
          }

          $data['From_Date'] = $frmDate;
          $data['To_date'] = $toDate;
          $data['pickup_Time'] =$pickupTime;
          $data['return_time'] = $returnTime;
          $data['Days'] = $days;
          $data['City'] = @$resCity->city_name;
          $data['city_id'] = @$resCity->city_id;
          $data['Location'] = @$resLoc->location_name;
          $data['location_id'] = @$resLoc->city_loc_id;
          Session::put('days',$days);
          Session::put('city_name',@$resCity->city_name);
          Session::put('location_name',@$resLoc->location_name);
   
          if(!$days==0)
            {
              if (!$id==0 && !$bid==0) { //if both vehcile type and brand is selected

               if($id!=13 && $bid!=29)
                {
                
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$id)->where('modals.makers','=',$bid)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }else{
                
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }
                
              }elseif(!$id==0 && $bid==0) //if vehice type only is selected
              {

                if(!$id==0 && $id!= 13){
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$id)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }else{
                
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }
              }elseif($id==0 && !$bid==0) //if braND alone is selected
              {
                if(!$bid==0  && $bid!=29){

                   $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.makers','=',$bid)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
               
                }else{
                  
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
               
                }
              }else{ //if not filter is selected
                
                $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
              }
             
              $car=array();
              $spec=array();
              foreach ($modList as $modList) { 
                  $modalId = $modList->modal_id;
                  $car['Model_id'] = $modList->modal_id;
                  $car['Model_name']=$modList->modal_name;
                  $car['Model_category'] = $modList->category->model_cat_name;
                  //image
                  $modImage = Model_image::where('model_id',$modList->modal_id)->where('model_image_flag','=',0)->get();
                      
                      foreach($modImage as $modImages)
                      {
                      $car['Model_image'] = $modImages->model_image;
                      }
                  //specifications
                  $resSpec = Model_specification::where('model_id','=',$modList->modal_id)->where('is_active','=',1)->get();
                  foreach ($resSpec as $resSpecs) {
                    $gtspec['Spec_name'] = $resSpecs->specs['spec_name'];
                    $gtspec['Spec_Image'] = $resSpecs->specs['spec_icon'];
                    array_push($spec,$gtspec);
                  }
                  $car['specifications'] = $spec;
                  $typoo = Helper::setType($days);
                 
                  //rate
                  if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }
                  
                   foreach ($rateType as $rateTypes) {
                    
                      $fetchrate = $rateTypes->rate; //get rate from the table //rate
                      $fetchOfferRate = Helper::checkOffer($rateTypes->model_rate_id,$modList->modal_id);
                      
                      if($curType)
                       {
                          $fetchCurrency = Currency::where('currency_id','=',$curType)->first();
                          $car['Currency_code'] = $fetchCurrency->currency_code;
                          $curConvertRate = $fetchCurrency->currency_conversion_rate;
                          if($fetchOfferRate<$fetchrate)
                          {
                            $rate = $fetchOfferRate*$curConvertRate;
                          }else{
                            $rate = $fetchrate*$curConvertRate;
                          }
                       
                        }

                       $car['Rate_code'] = $rateTypes->rates->rate_type_code;
                       Session::put('rate_type',$rateTypes->rates->rate_type_code);
                       $car['Total_Rates'] = Helper::showList($days,$rate);
                       $rt = Helper::showList($days,$rate);
                       $car['Total_Rate'] = $rt['totValue'];
                       Session::put('totvalue',$rt['totValue']);
                       $car['Rate_per_day'] = $rt['perDayRate'];
                       Session::put('dailyRT',$rt['perDayRate']);
                       $car['Main_Rate']= $fetchrate;
                        $car['Model_Year']= $rateTypes->model_year;
                        $car['Maker']= $rateTypes->maker_id;
                       $car['Offer_Rate'] = $fetchOfferRate;
                       
                     array_push($model,$car); 
                   
                     }
                }
             
              $data['Models'] = $model;
            
            }else{
             
              $data['message'] = "No Cars available";
            }
            
            return view('front-end.elements.car.search',compact('fetcCurrency','vehicleType','vehicleMaker','parseFrmDt','data','parseToDate','fetchCity','id','bid'),$data);
          }else{
            return redirect('/');
          }
    }
    
    

    public function getLocation(Request $request)
    {
            $sid        =   $request->city_id;
            $location   = City_location::where("city_id",'=',$sid)->pluck("ar_location_name","location_name","city_loc_id");
            
            return response()->json($location);
    }

    public function carDetail(Request $request, $id)
    {
      if(Session::has('fromdate')||Session::has('todate'))
      {
        $carId = Crypt::decryptString($id);
        $fetchModel = Modal::where('modal_id','=',$carId)->first();
        $ModelImage = Model_image::where('model_id',$fetchModel->modal_id)->where('model_image_flag','=',0)->first();
        $modelSpec =  Model_specification::where('model_id','=',$fetchModel->modal_id)->where('is_active','=',1)->get();
        $getCont = Country::orderBy('country_id','ASC')->get();
        $fetchCity = City::orderBy('city_id','DESC')->get();
        $getTerms = Setting::where('id','=','1')->first();
        $getInfo = Setting::where('id','=','2')->first();
        return view('front-end.elements.car.detail',compact('carId','fetchModel','ModelImage','modelSpec','getCont','fetchCity','getTerms','getInfo'));
    }else{
      return redirect('/');
    }
    }

    public function getPersonalInfo(Request $request)
    {
      if(Session::has('fromdate')||Session::has('todate'))
      {
        if (Session::has('model_id')) 
        {
          $carId = Session::get('model_id');
           $Total_Rate = Session::get('total_rate');
            $Rate_per_day = Session::get('rate_per_day');

        }
        else{

          $carId = $request->input('model_id');
           $Total_Rate = $request->input('total_rate');
          $Rate_per_day = $request->input('rate_per_day');
           Session::put('model_id',$carId);
           Session::put('total_rate',$Total_Rate);
            Session::put('rate_per_day',$Rate_per_day);
        }
      
      
      $fetchModel = Modal::where('modal_id','=',$carId)->first();
      $ModelImage = Model_image::where('model_id',$fetchModel->modal_id)->where('model_image_flag','=',0)->first();
      $modelSpec =  Model_specification::where('model_id','=',$fetchModel->modal_id)->where('is_active','=',1)->get();
      $getCont = Country::orderBy('country_id','ASC')->get();
      $fetchCity = City::orderBy('city_id','DESC')->get();
      // $Total_Rate = $request->input('total_rate');
      // $Rate_per_day = $request->input('rate_per_day');
      $getTerms = Setting::where('id','=','1')->first();
      $getInfo = Setting::where('id','=','2')->first();
      return view('front-end.elements.car.detail',compact('carId','fetchModel','ModelImage','modelSpec','getCont','fetchCity','getTerms','getInfo','Total_Rate','Rate_per_day'));
       }else{
      return redirect('/');
    }

    }

    public function userInfoSave(Request $request)
    {
      if(Session::has('total_amount_applied'))
      {
        Session::forget('total_amount_applied');
      }
      if(Session::has('coupon_code'))
      {
        Session::forget('coupon_code');
      }
      $data['fName'] = $request->first_name;
      $data['lName'] = $request->last_name;
      $data['MobileNumber'] = $request->mobile_number;
      $data['custDob'] = $request->customer_dob;
      $data['custQatarId'] = $request->customer_qatar_id;
      $data['custPassNumber'] = $request->customer_passport_number;
      $data['custNationality'] = $request->cust_nationality;
      $data['address1'] = $request->cust_address_line_1;
      $data['address2'] = $request->cust_address_line_2;
      $data['custmrCity'] = $request->cust_city;
      $data['custLocation'] = $request->cust_location;
      $data['custZipcode'] = $request->cust_zipcode;
      $data['rate_per_day'] = $request->rate_per_day;
      $data['total_rate'] = $request->total_rate;
      $coupons=Coupon::all();
      $fetchModel  = Modal::where('modal_id','=',$request->model_id)->first();
      $ModelImage = Model_image::where('model_id',$request->model_id)->where('model_image_flag','=',0)->first();

      $modelSpec =  Model_specification::where('model_id','=',$request->model_id)->where('is_active','=',1)->get();

      if(Auth::guard('main_customer')->check())
      {
        return view('front-end.elements.car.payment-page',compact('data','fetchModel','modelSpec','ModelImage','coupons'),$data);

      }else{
        Session::put('login-confirmation','1');
        return redirect('user-login');
      }

    }
    public function applyCoupon(Request $request)
    {
      $total_amount=$request->total_amount;
      if(Auth::guard('main_customer')->check())
      {
      $coupon_code=$request->coupon_code;
      
      //return $total_amount;
      $coupon=Coupon::where('coupon_code',$coupon_code);
      if(!$coupon->exists())
      {
       return response()->json(['status'=>0,'total_rate'=>$total_amount]);
      }
      else
      {
        if(date('Y-m-d')>$coupon->first()->end_date)
        {
          return response()->json(['status'=>5,'total_rate'=>$total_amount]);
        }
        if($coupon->first()->minimum_order_amount>=$total_amount)
        {
          return response()->json(['status'=>6,'total_rate'=>$total_amount]);
        }
        
      }
      $customer_coupon=CustomerCoupon::where('customer_id',Auth::guard('main_customer')->user()->id)->where('coupon_id',@$coupon->first()->id);
      if($customer_coupon->exists())
      {
        return response()->json(['status'=>1,'total_rate'=>$total_amount]);
      }
      else
      {
        $customer_coupon=new CustomerCoupon();
        $customer_coupon->coupon_id=$coupon->first()->id;
        $customer_coupon->customer_id=Auth::guard('main_customer')->user()->id;
        $customer_coupon->is_applied=1;
        $customer_coupon->save();
        if($coupon->first()->discount_type==1)
        {
          $total_amount_applied=$total_amount-$coupon->first()->discount_value;
        }
        if($coupon->first()->discount_type==2)
        {
          $total_amount_applied=$total_amount-($total_amount*$coupon->first()->discount_value)/100;
        }
        Session::put('total_amount_applied',$total_amount_applied);
        Session::put('coupon_code',$coupon->first()->coupon_code);
       
        return response()->json(['status'=>2,'total_rate'=>number_format($total_amount_applied,2)]);
      }
      return response()->json(['status'=>3,'total_rate'=>$total_amount]);
    }
    else
    {
      return response()->json(['status'=>4,'total_rate'=>$total_amount]);
    }

    }

    public function bookingSave(Request $request, Booking $booking)
    {
      if(Session::has('fromdate')||Session::has('todate'))
      {
      $custName = ucfirst(Auth::guard('main_customer')->user()->customer->cust_fname) . ' ' . ucfirst(Auth::guard('main_customer')->user()->customer->cust_lname);
      $referIdCheck = Booking::latest('book_id')->first(); //check if any booking exist in tb and fetch its reference id
      
        if($referIdCheck)
        {
            $fetchId = $referIdCheck->book_ref_id;
            $ReferId = $fetchId+1;
        }else{
            $ReferId ="34332";
        }
        
        $currency = Session::get('cur_code');
        //$request->book_total_rate=session()->get('total_rate')??$request->book_total_rate;
        $datas= $request->except('_token');
      
        $currDetail = Booking::insertGetId($datas);
        Booking::where('book_id','=',$currDetail)->update([
          'currency_id' => $currency,
          'drop_fee' => '0.00',
          'additional_package' => '0.00',
          'book_ref_id' => $ReferId,
          'book_status' =>1, //pending payment
          'book_total_rate'=>Session::get('total_amount_applied')??$request->book_total_rate,
          'coupon_code'=>Session::get('coupon_code')??NULL,
          'created_at' =>\Carbon\Carbon::now(),
          'updated_at' =>\Carbon\Carbon::now()

        ]);
        Session::put('booking_ref_id',$ReferId);
        Session::put('Name',$custName);
        $TotalAmnt = Session::get('total_amount_applied')??$request->book_total_rate;
       // Session::forget('total_rate');
        //Doha bank payment gateway 
        	$orderid= $this->generateRandomString(6);
	        $merchant="DB95927"; 
        	$apipassword="afbc40219aa0e4eb35e3ebfd46d809e8"; 
	        $amount=$TotalAmnt;
	        $returnUrl = URL::to('booking-success');
	        $currency = "QAR";
          Session::forget('total_amount_applied');
          Session::forget('fromdate');
          Session::forget('todate');
	        $url = "https://dohabank.gateway.mastercard.com/api/rest/version/57/merchant/DB95927/session";
	
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

$data = <<<DATA
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


curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

//for debug only!
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($ch);

$response = json_decode($resp);

// exit;
curl_close($ch);

$sessionid = $response->session->id;
Session::put('orderId',$orderid);
return view('front-end.elements.payment.payment-connect',compact('response','sessionid','amount','currency','orderid'));
        // return redirect('booking-success');
        }else{
      return redirect('/');
    }

    }

    public function bookingSuccess(Request $request)
    {
      $referenceId = Session::get('booking_ref_id');
      $Name = Session::get('Name');
      
      $data = array('booking_ref_id'=>$referenceId,'to_mail'=>'testdeveloper@webprojects.hexeam.in');
             Mail::send('front-end/mail-templates/admin-booking-template', $data, function($message) use ($data){
                 $message->to($data['to_mail'], 'RENT SOLUTIONS')->subject
                    ('NEW BOOKING');
                $message->from('testdeveloper@webprojects.hexeam.in','RENT SOLUTIONS - NEW BOOKING RECIEVED');
        });
      
      Booking::where('book_ref_id','=',$referenceId)->update([
            'book_status' =>4, //confirmed
            ]);
            
        
      
      return view('front-end.elements.car.booking-success',compact('referenceId','Name'));
    }
    
    public function orderCancel($id)
    {
        $decrId = Crypt::decryptString($id);
        $orderId = Session::get('orderId');
        $referenceId = Session::get('booking_ref_id');
        $Name = Session::get('Name');
       
        Booking::where('book_ref_id','=',$referenceId)->update([
            'book_status' =>3, //payment Failed 
            ]);
            return view('front-end.elements.car.booking-failed',compact('referenceId','Name'));
        
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
    
    public function bookAgain(Request $request)
    {
       $data = array();
      $model = array();
      $carId = $request->model_id;
      $fetchModel = Modal::where('modal_id','=',$carId)->first();
      $ModelImage = Model_image::where('model_id',$fetchModel->modal_id)->where('model_image_flag','=',0)->first();
      $modelSpec =  Model_specification::where('model_id','=',$fetchModel->modal_id)->where('is_active','=',1)->get();
      $getCont = Country::orderBy('country_id','ASC')->get();
      $fetchCity = City::orderBy('city_id','DESC')->get();
        $getTerms = Setting::where('id','=','1')->first();
        $getInfo = Setting::where('id','=','2')->first();
      $locId = $request->input('city_loc_id');
      $cityId = $request->input('city_id');
      $frmDate = $request->input('from_date');
      $toDate = $request->input('to_date');
      $pickupTime = $request->input('pickup_time');
      $returnTime = $request->input('return_time');
      $curType = $request->input('cur_type'); //default currency value of qatar riyal is set to 0
          Session::put('location',$locId);
          Session::put('city',$cityId);
          Session::put('fromdate',$frmDate);
          Session::put('todate',$toDate);
          Session::put('pickupTime',$pickupTime);
          Session::put('returnTime',$returnTime);
          Session::put('currency_type',$curType);
       $resCity =City::where('city_id','=',$cityId)->first(); //Get City
          $resLoc = City_location::where('city_loc_id','=',$locId)->first(); //Get Location
          $parseFrmDt = Helper::parseCarbon($frmDate); 
          $parseToDate = Helper::parseCarbon($toDate);
          $parsePickTime = Helper::parseCarbon($pickupTime);
          $parseRetTime = Helper::parseCarbon($returnTime);
          $diff = $parsePickTime->diffInHours($parseRetTime);
          $combinedfrom = date('Y-m-d H:i:s', strtotime("$frmDate $pickupTime"));
          $combinedto = date('Y-m-d H:i:s', strtotime("$toDate $returnTime"));
          $parsecombinefrom = Helper::parseCarbon($combinedfrom); 
          $parsecombineto = Helper::parseCarbon($combinedto); 
          $diffDays2 = $parsecombinefrom->diffInDays($parsecombineto);
          $mins            = $parseRetTime->diffInMinutes($parsePickTime, true);
          $totMins = ($mins/60);
          
          //get number of days
          if($totMins > 3 && $diff <= 12  && $diffDays2 >= 1)
          {
            $days=$parseFrmDt->diffInDays($parseToDate)+1;  
          }else{
             $days=$parseFrmDt->diffInDays($parseToDate); 
          }
          
          
          $data['From_Date'] = $frmDate;
          $data['To_date'] = $toDate;
          $data['pickup_Time'] =$pickupTime ;
          $data['return_time'] = $returnTime;
          $data['Days'] = $days;
          $data['City'] = $resCity->city_name;
          $data['city_id'] = $resCity->city_id;
          $data['Location'] = $resLoc->location_name;
          $data['location_id'] = $resLoc->city_loc_id;
          Session::put('days',$days);
          Session::put('city_name',$resCity->city_name);
          Session::put('location_name',$resLoc->location_name);
           if(!$days==0)
            {
             
                $modList= Modal::where('modal_id','=',$carId)->first();
                $car=array();
                $typoo = Helper::setType($days);
                if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }
            
                foreach ($rateType as $rateTypes) {
                    
                      $fetchrate = $rateTypes->rate; //get rate from the table //rate
                      $fetchOfferRate = $rateTypes->model_min_rate; //get offer rate from table
                      if($curType)
                       {
                          $fetchCurrency = Currency::where('currency_id','=',$curType)->first();
                          $data['Currency_code'] = $fetchCurrency->currency_code;
                          $curConvertRate = $fetchCurrency->currency_conversion_rate;
                          if($fetchOfferRate<$fetchrate)
                          {
                            $rate = $fetchOfferRate*$curConvertRate;
                          }else{
                            $rate = $fetchrate*$curConvertRate;
                          }
                        }

                       $data['Rate_code'] = $rateTypes->rates->rate_type_code;
                       Session::put('rate_type',$rateTypes->rates->rate_type_code);
                       $data['Total_Rates'] = Helper::showList($days,$rate);
                       $rt = Helper::showList($days,$rate);
                       $data['Total_Rate'] = $rt['totValue'];
                       $data['Rate_per_day'] = $rt['perDayRate'];
                       $data['Main_Rate']= $fetchrate;
                       $data['Offer_Rate'] = $fetchOfferRate;
                       
                     // array_push($model,$car); 
                   
                     }
             
             
              // $data['Models'] = $model;
                 
            }else{
             
              return redirect()->back()->with('status','Date Should not be less than 1');
            }

      return view('front-end.elements.car.detail',compact('carId','fetchModel','ModelImage','modelSpec','getCont','fetchCity','getTerms','getInfo'),$data);
    }

    public function changeCurrency(Request $request, $id)
    {
      $cId = Crypt::decryptString($id);
      if(Session::has('fromdate')||Session::has('todate'))
      {
       $fetcCurrency = Currency::orderBy('currency_id','DESC')->get();
      $fetchCity = City::orderBy('city_id','DESC')->get();
      $vehicleType = Model_category::orderBy('model_cat_id','DESC')->get();
       $vehicleMaker = Maker::orderBy('maker_id','DESC')->get();
      $getCurrency = Currency::where('currency_id','=',$cId)->first();
      $getCode = $getCurrency->currency_code;
      Session::put('cur_type',$cId);
      Session::put('cur_code',$getCode);
      $data = array();
      $model = array();

        $locId = Session::get('location');
          $cityId = Session::get('city');
          $frmDate =Session::get('fromdate');
          $toDate = Session::get('todate');
          $pickTime = Session::get('pickupTime');
          $retnTime = Session::get('returnTime');
          $curType = Session::get('cur_type'); //default currency value of qatar riyal is set to 0
          // Session::put('location',$locId);
          // Session::put('city',$cityId);
          // Session::put('fromdate',$frmDate);
          // Session::put('todate',$toDate);
          // Session::put('pickupTime',$pickupTime);
          // Session::put('returnTime',$returnTime);
          // Session::put('currency_type',$curType);
       $resCity =City::where('city_id','=',$cityId)->first(); //Get City
          $resLoc = City_location::where('city_loc_id','=',$locId)->first(); //Get Location
          $parseFrmDt = Helper::parseCarbon($frmDate); 
          $parseToDate = Helper::parseCarbon($toDate);
          $parsePickTime = Helper::parseCarbon($pickTime);
          $parseRetTime = Helper::parseCarbon($retnTime);
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
          if($totMins > 3 && $diff <= 12  && $diffDays2 >= 1)
          {
            $days=$parseFrmDt->diffInDays($parseToDate)+1;  
          }else{
             $days=$parseFrmDt->diffInDays($parseToDate); 
          }
         
          $data['From_Date'] = $frmDate;
          $data['To_date'] = $toDate;
          $data['pickup_Time'] =Session::get('pickupTime');
          $data['return_time'] = Session::get('returnTime');
          $data['Days'] = $days;
          $data['City'] = $resCity->city_name;
          $data['city_id'] = $resCity->city_id;
          $data['Location'] = $resLoc->location_name;
          $data['location_id'] = $resLoc->city_loc_id;
          Session::put('days',$days);
          Session::put('city_name',$resCity->city_name);
          Session::put('location_name',$resLoc->location_name);
           if(!$days==0)
            {
             
                $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
              
              
              $car=array();
              foreach ($modList as $modList) { 
                  $modalId = $modList->modal_id;
                  $car['Model_id'] = $modList->modal_id;
                  $car['Model_name']=$modList->modal_name;
                  $car['Maker']=$modList->maker->maker_name;
                  $car['Model_category'] = $modList->category->model_cat_name;
                  //image
                  $modImage = Model_image::where('model_id',$modList->modal_id)->where('model_image_flag','=',0)->get();
                      
                      foreach($modImage as $modImages)
                      {
                      $car['Model_image'] = $modImages->model_image;
                      }
                    //specifications
                    $resSpec = Model_specification::where('model_id','=',$modList->modal_id)->where('is_active','=',1)->get();
                    $spec=array();
                  foreach ($resSpec as $resSpecs) {
                    $gtspec['Spec_name'] = $resSpecs->specs['spec_name'];
                    $gtspec['Spec_Image'] = $resSpecs->specs['spec_icon'];
                    array_push($spec,$gtspec);
                  }
                  $car['specifications'] = $spec;
                  $typoo = Helper::setType($days);
                  //rate
                  if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }
               
                   foreach ($rateType as $rateTypes) {
                    
                      $fetchrate = $rateTypes->rate; //get rate from the table //rate
                      $fetchOfferRate = $rateTypes->model_min_rate; //get offer rate from table

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
                       Session::put('rate_type',$rateTypes->rates->rate_type_code);
                       $car['Total_Rates'] = Helper::showList($days,$rate);
                       $rt = Helper::showList($days,$rate);
                       $car['Total_Rate'] = $rt['totValue'];
                       Session::put('totvalue',$rt['totValue']);
                       $car['Rate_per_day'] = $rt['perDayRate'];
                       Session::put('dailyRT',$rt['perDayRate']);
                        $car['Model_Year']= $rateTypes->model_year;
                        $car['Maker']= $rateTypes->maker_id;
                       $car['Main_Rate']= $mainRat;
                       $car['Offer_Rate'] = $mainOffer;
                       
                     array_push($model,$car); 
                   
                     }
                }
             
              $data['Models'] = $model;
                 
            }else{
             
              $data['message'] = "No Cars available";
            }

      return view('front-end.elements.car.search',compact('fetcCurrency','vehicleType','parseFrmDt','vehicleMaker','data','parseToDate','fetchCity'),$data);
       }else{
      return redirect('/');
    }
    }
    
    
   
    public function sortCar(Request $request, $sort, $id=NULL)
    {
       
        if(Session::has('cur_type'))
      {
          
      $fetcCurrency = Currency::orderBy('currency_id','DESC')->get();
      $fetchCity = City::orderBy('city_id','DESC')->get();
      $vehicleType = Model_category::orderBy('model_cat_id','DESC')->get();
      $vehicleMaker = Maker::where('maker_name','!=','Not Defined')->orderBy('maker_id','DESC')->get();
      $data = array();
      $model = array();
      $bid=$id;
  
    //   if($id==NULL)
    //   {
          
    //     $locId = $request->input('city_loc_id');
    //       $cityId = $request->input('city_id');
    //       $frmDate = $request->input('from_date');
    //       $toDate = $request->input('to_date');
    //       $pickupTime = $request->input('pickup_time');
    //       $returnTime = $request->input('return_time');
    //       // $curType = $request->input('cur_type'); //default currency value of qatar riyal is set to 0
    //       $curType = Session::get('cur_type');
    //       // dd($curType);
    //       Session::put('location',$locId);
    //       Session::put('city',$cityId);
    //       Session::put('fromdate',$frmDate);
    //       Session::put('todate',$toDate);
    //       Session::put('pickupTime',$pickupTime);
    //       Session::put('returnTime',$returnTime);
    //       Session::put('currency_type',$curType);

    //   }else{
       $locId = Session::get('location');
          $cityId = Session::get('city');
          $frmDate =Session::get('fromdate');
          $toDate = Session::get('todate');
          $pickupTime = Session::get('pickupTime');
          $returnTime = Session::get('returnTime');
          $curType = Session::get('currency_type');
          
    //   }
      
          
          $resCity =City::where('city_id','=',$cityId)->first(); //Get City
          $resLoc = City_location::where('city_loc_id','=',1)->first(); //Get Location
          $parseFrmDt = Helper::parseCarbon($frmDate); 
          $parseToDate = Helper::parseCarbon($toDate);
          $parsePickTime = Helper::parseCarbon($pickupTime);
          $parseRetTime = Helper::parseCarbon($returnTime);
          $diff = $parsePickTime->diffInHours($parseRetTime);
          $combinedfrom = date('Y-m-d H:i:s', strtotime("$frmDate $pickupTime"));
          $combinedto = date('Y-m-d H:i:s', strtotime("$toDate $returnTime"));
          $parsecombinefrom = Helper::parseCarbon($combinedfrom); 
          $parsecombineto = Helper::parseCarbon($combinedto); 
          $diffDays2 = $parsecombinefrom->diffInDays($parsecombineto);
          $mins            = $parseRetTime->diffInMinutes($parsePickTime, true);
          $totMins = ($mins/60);
          
          //get number of days
          if($totMins > 3 && $diff <= 12  && $diffDays2 >= 1)
          {
              
                $days=$parseFrmDt->diffInDays($parseToDate)+1; 
            
          }else{
             $days=$parseFrmDt->diffInDays($parseToDate); 
          }
        //   dd($diff,$diffDays,$days);
           
        //   dd($parseFrmDt,$parsePickTime,$parseToDate,$parseRetTime,$days,$diff);
          $data['From_Date'] = $frmDate;
          $data['To_date'] = $toDate;
          $data['pickup_Time'] =$pickupTime;
          $data['return_time'] = $returnTime;
          $data['Days'] = $days;
          $data['City'] = @$resCity->city_name;
          $data['city_id'] = @$resCity->city_id;
          $data['Location'] = @$resLoc->location_name;
          $data['location_id'] = @$resLoc->city_loc_id;
          Session::put('days',$days);
          Session::put('city_name',@$resCity->city_name);
          Session::put('location_name',@$resLoc->location_name);
        
   
          if(!$days==0)
            {
              if(!$id==NULL && $id!= 13){
                  
                $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$id)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
              }else{
                
                $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
              }
              
             
              $car=array();
               $spec=array();
              foreach ($modList as $modList) { 
                  $modalId = $modList->modal_id;
                  $car['Model_id'] = $modList->modal_id;
                  $car['Model_name']=$modList->modal_name;
                //   $car['Maker']=$modList->maker->maker_name;
                  $car['Model_category'] = $modList->category->model_cat_name;
                  //image
                  $modImage = Model_image::where('model_id',$modList->modal_id)->where('model_image_flag','=',0)->get();
                      
                      foreach($modImage as $modImages)
                      {
                      $car['Model_image'] = $modImages->model_image;
                      }
                    //specifications
                    $resSpec = Model_specification::where('model_id','=',$modList->modal_id)->where('is_active','=',1)->get();
                   
                  foreach ($resSpec as $resSpecs) {
                    $gtspec['Spec_name'] = $resSpecs->specs['spec_name'];
                    $gtspec['Spec_Image'] = $resSpecs->specs['spec_icon'];
                    array_push($spec,$gtspec);
                  }
                  $car['specifications'] = $spec;
                  $typoo = Helper::setType($days);
                  

                  //rate
                  if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->orderBy('model_min_rate','ASC')->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->orderBy('model_min_rate','ASC')->get(); 
                  }
                 
                  
                  
               
                   foreach ($rateType as $rateTypes) {
                    
                      $fetchrate = $rateTypes->rate; //get rate from the table //rate
                      $fetchOfferRate = $rateTypes->model_min_rate; //get offer rate from table
                      if($curType)
                       {
                          $fetchCurrency = Currency::where('currency_id','=',$curType)->first();
                          $car['Currency_code'] = $fetchCurrency->currency_code;
                          $curConvertRate = $fetchCurrency->currency_conversion_rate;
                          if($fetchOfferRate<$fetchrate)
                          {
                            $rate = $fetchOfferRate*$curConvertRate;
                          }else{
                            $rate = $fetchrate*$curConvertRate;
                          }
                       
                        }


                       $car['Rate_code'] = $rateTypes->rates->rate_type_code;
                       Session::put('rate_type',$rateTypes->rates->rate_type_code);
                       $car['Total_Rates'] = Helper::showList($days,$rate);
                       $rt = Helper::showList($days,$rate);
                       $car['Total_Rate'] = $rt['totValue'];
                       Session::put('totvalue',$rt['totValue']);
                       $car['Rate_per_day'] = $rt['perDayRate'];
                       Session::put('dailyRT',$rt['perDayRate']);
                       $car['Main_Rate']= $fetchrate;
                        $car['Model_Year']= $rateTypes->model_year;
                        $car['Maker']= $rateTypes->maker_id;
                       $car['Offer_Rate'] = $fetchOfferRate;
                       
                     array_push($model,$car); 
                   
                     }
                }
               
        
                if($sort==1)
                {
                  $model = $this->array_sort($model,'Main_Rate', SORT_ASC);
                }
                else
                {
                  $model = $this->array_sort($model,'Main_Rate', SORT_DESC);
                }
              
              $data['Models'] = $model;
            //  dd($data);
                 
            }else{
             
              $data['message'] = "No Cars available";
            }
            

            return view('front-end.elements.car.search',compact('id','bid','fetcCurrency','vehicleType','vehicleMaker','parseFrmDt','data','parseToDate','fetchCity'),$data);
          }else{
            return redirect('/');
          }
    }

  public function webCarsist(Request $request)
  {
    //get current date and time
          $curDt = Carbon::now();
          $frmdt  = $curDt->format('m/d/Y'); //current from date
          $toDat = $curDt->addDays(1);
          $formatToDat = $toDat->format('m/d/Y'); //to date

          $vehcleType = $request->input('vehicle_type');
          $brandType = $request->input('brand_type');
          $frmDate = $request->input('from_date');
          $toDate = $request->input('to_date');
          $pickupTime = "10:00";
          $returnTime = "10:00";
          $curType = Session::get('currency_type'); 

          $parseFrmDt = Helper::parseCarbon($frmDate); //parse from date to carbon format
          $parseToDate = Helper::parseCarbon($toDate); //parse to date to carbon format
          $parsePickTime = Helper::parseCarbon($pickupTime); //parse picktime to carbon format
          $parseRetTime = Helper::parseCarbon($returnTime); //parse returntime to carbon format
          $diff = $parsePickTime->diffInHours($parseRetTime); //find hour difference based on time
          $diffDays = $parseFrmDt->diffInDays($parseToDate); //find days difference based on date
          //calculate the difference w.r.t to time
          $combinedfrom = date('Y-m-d H:i:s', strtotime("$frmDate $pickupTime"));
          $combinedto = date('Y-m-d H:i:s', strtotime("$toDate $returnTime"));
          $parsecombinefrom = Helper::parseCarbon($combinedfrom); 
          $parsecombineto = Helper::parseCarbon($combinedto); 
          $diffDays2 = $parsecombinefrom->diffInDays($parsecombineto);
          $mins            = $parseRetTime->diffInMinutes($parsePickTime, true);
          $totMins = ($mins/60);
          
          //get number of days
          if($totMins > 3 && $diff <= 12  && $diffDays2 >= 1)
          {
                $days=$parseFrmDt->diffInDays($parseToDate)+1; 
            
          }else{
             $days=$parseFrmDt->diffInDays($parseToDate); 
          }

          $data['From_Date'] = $frmDate;
          $data['To_date'] = $toDate;
          $data['pickup_Time'] =$pickupTime;
          $data['return_time'] = $returnTime;
          $data['Days'] = $days;
          $data['City'] = $resCity->city_name;
          $data['city_id'] = $resCity->city_id;
          $data['Location'] = $resLoc->location_name;
          $data['location_id'] = $resLoc->city_loc_id;
          Session::put('days',$days);
          Session::put('city_name',$resCity->city_name);
          Session::put('location_name',$resLoc->location_name);
   
          if(!$days==0)
            {
                
                $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
             
             
              $car=array();
              $spec=array();
              foreach ($modList as $modList) { 
                  $modalId = $modList->modal_id;
                  $car['Model_id'] = $modList->modal_id;
                  $car['Model_name']=$modList->modal_name;
                  $car['Model_category'] = $modList->category->model_cat_name;
                  //image
                  $modImage = Model_image::where('model_id',$modList->modal_id)->where('model_image_flag','=',0)->get();
                      
                      foreach($modImage as $modImages)
                      {
                      $car['Model_image'] = $modImages->model_image;
                      }
                  //specifications
                  $resSpec = Model_specification::where('model_id','=',$modList->modal_id)->where('is_active','=',1)->get();
                  foreach ($resSpec as $resSpecs) {
                    $gtspec['Spec_name'] = $resSpecs->specs['spec_name'];
                    $gtspec['Spec_Image'] = $resSpecs->specs['spec_icon'];
                    array_push($spec,$gtspec);
                  }
                  $car['specifications'] = $spec;
                  $typoo = Helper::setType($days);
                 
                  //rate
                  if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }
                  
                   foreach ($rateType as $rateTypes) {
                    
                      $fetchrate = $rateTypes->rate; //get rate from the table //rate
                      $fetchOfferRate = $rateTypes->model_min_rate; //get offer rate from table
                      if($curType)
                       {
                          $fetchCurrency = Currency::where('currency_id','=',$curType)->first();
                          $car['Currency_code'] = $fetchCurrency->currency_code;
                          $curConvertRate = $fetchCurrency->currency_conversion_rate;
                          if($fetchOfferRate<$fetchrate)
                          {
                            $rate = $fetchOfferRate*$curConvertRate;
                          }else{
                            $rate = $fetchrate*$curConvertRate;
                          }
                       
                        }

                       $car['Rate_code'] = $rateTypes->rates->rate_type_code;
                       Session::put('rate_type',$rateTypes->rates->rate_type_code);
                       $car['Total_Rates'] = Helper::showList($days,$rate);
                       $rt = Helper::showList($days,$rate);
                       $car['Total_Rate'] = $rt['totValue'];
                       Session::put('totvalue',$rt['totValue']);
                       $car['Rate_per_day'] = $rt['perDayRate'];
                       Session::put('dailyRT',$rt['perDayRate']);
                       $car['Main_Rate']= $fetchrate;
                        $car['Model_Year']= $rateTypes->model_year;
                        $car['Maker']= $rateTypes->maker_id;
                       $car['Offer_Rate'] = $fetchOfferRate;
                       
                     array_push($model,$car); 
                   
                     }
                }
             
              $data['Models'] = $model;
              //dd($model);
            
            }else{
             
              $data['message'] = "No Cars available";
            }
  }
  function array_sort($array, $on, $order=SORT_ASC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

































}
