<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\Currency;
use App\Models\City_location;
use App\Models\Customer;
use App\Models\Mst_service;
use Session;
use App\Slider;
use App\Models\Modal;
use App\Models\Maker;
use App\Models\Booking;
use App\Models\Model_category;
use App\Models\Rate_type;
use App\Models\Mode_rate;
use App\Models\Model_image;
use App\Models\Setting;
use App\Models\Model_specification;
use App\Models\Country;
use App\Models\Mst_page_data;
use Illuminate\Support\Facades\DB;
use App\Models\Mst_contact_us;
use App\Models\Trn_contact_enquiries;
use Crypt;
use App\Helpers\Helper;
use  Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\URL;
use Mail;


class HomeController extends Controller
{
    public function badpage()
    {
        return view('front-end.elements.error.bad-page');
    }
    
    public function weblogin()
    {
        return view('front-end.includes.loginhead');
    }
    public function index(Request $request)
    {
        Session::forget('location');
        $fetchCity = City::orderBy('city_id','DESC')->get();
        $fetchLocation = City_location::orderBy('city_loc_id','DESC')->get();
        $getCurrency = Currency::where('currency_id','=',1)->first();
        $curId = $getCurrency->currency_id;
        $curCode = $getCurrency->currency_code;
        Session::put('cur_type',$curId);
        Session::put('cur_code',$curCode);
        $fetchService = Mst_service::orderBy('service_id','ASC')->limit(3)->get();
        $fetchCarService = Mst_service::where('service_id',21)->first();
        $fetchLimService = Mst_service::where('service_id',16)->first();
        $fetchQuickService = Mst_service::where('service_id',3)->first();
        $fetchCarSale = Mst_service::where('service_id',20)->first();
        $sliders=Slider::orderBy('id','ASC')->get();
        $fetchCarList = $this->webCarsist();
        $whyChooseUs = Mst_page_data::where('page_name','=','why-choose-us')->first();
        $pageTitle = "Al Mana Leasing: Premier Car Rentals in Doha";
        $pageDescription = "Discover top-tier car rental and leasing options with Al Mana Leasing. Experience the best in quality, service, and value in Doha.";
    	return view('front-end.website.index',compact('fetchCity','fetchLocation','fetchService','fetchCarList','whyChooseUs','fetchCarService','fetchLimService','fetchQuickService','fetchCarSale','sliders','pageTitle','pageDescription'));
        // return view('front-end.website.index',compact('fetchCity','fetchLocation','fetchService','fetchCarList','whyChooseUs'));

    }

    
    public function carRentalPage(Request $request)
    {
        // $request->session()->flush();
        Session::forget('location');
        $fetchCity = City::orderBy('city_id','DESC')->get();
        $fetchLocation = City_location::orderBy('city_loc_id','DESC')->get();
        $getCurrency = Currency::where('currency_id','=',1)->first();
        $curId = $getCurrency->currency_id;
        $curCode = $getCurrency->currency_code;
        Session::put('cur_type',$curId);
        Session::put('cur_code',$curCode);
        $pageTitle = "Car Rental Services in Doha";
        $pageDescription = "Choose from a variety of rental cars at Al Mana Leasing. Find affordable, flexible rental options for your next trip.";

        return view('front-end.index',compact('fetchCity','fetchLocation','pageTitle','pageDescription'));
    }


    public function account()
    {
    	if(Auth::guard('main_customer')->check())
    	{
    		return view('front-end.elements.account.index');
    	}else{
        return redirect('/');
      }
    }

    public function contactPage()
    {
        $pageTitle = "Contact Al Mana Leasing";
        $pageDescription = "Get in touch with Al Mana Leasing for all your car rental and leasing inquiries. We're here to help you hit the road.";
        $fetchContent = Mst_contact_us::where('contact_id','=',1)->first();
        return view('front-end.elements.settings.contact',compact('fetchContent','pageTitle','pageDescription'));
    }

    public function saveContactEnquiry(Request $request, Trn_contact_enquiries $contact_us)
    {
      $validator = Validator::make($request->all(), [   
                'enquiry_fname' => 'required|regex:/^[\pL\s\-]+$/u',
                'enquiry_lname' => 'required|regex:/^[\pL\s\-]+$/u',
                'enquiry_email' => 'required|email',
                'enquiry_mobile' => 'required|integer',
                'enquiry_message' => 'required|max:400',
                'g-recaptcha-response'=>'required',
        ],
        [
            'g-recaptcha-response.required' => 'Please complete the captcha'
        ]);
        //dd($request->all());
        
        if(!$validator->fails())
            {
                $res=$request->input('recaptcha-response');
                $data = array('secret' => env('GOOGLE_RECAPTCHA_SECRET'),'response'=>$res);
                 $verify = curl_init();
                curl_setopt($verify, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
                curl_setopt($verify, CURLOPT_POST, true);
                curl_setopt($verify, CURLOPT_POSTFIELDS,
                http_build_query($data));
                curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($verify);
                $decoded_response = json_decode($response, true);
               
                $contact_us->contact_enquiry_fname = $request->enquiry_fname;
                $contact_us->contact_enquiry_lname =  $request->enquiry_lname;
                $contact_us->contact_enquiry_email_address = $request->enquiry_email;
                $contact_us->contact_enquiry_phone =$request->enquiry_mobile;
                $contact_us->contact_enquiry_message =  $request->enquiry_message;
                $contact_us->save();
   
                
                
                
                
               

                //send mail to the rentsolutions admin 

                return redirect()->back()->with('status','Success! Your message has been sent.');
            }else{
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
    }

    
    public function checkEmail(Request $request){

        $email=$request->email;
        $mailCheck =Customer::where("email",'=',$email)->get();
        return response()->json($mailCheck);

        }

        
    public function checkMobile(Request $request){

        $mobNumber=$request->mobNumber;
        // $mobilec=$request->mobilecode;
        // $str = ltrim($mobilec, '+');
        // $mobCheck = Customer::where('cust_mobile_code','=',$str)->where('cust_mobile_number','=',$mobNumber)->get();
        $mobCheck = Customer::where('cust_mobile_number','=',$mobNumber)->get();
        return response()->json($mobCheck);

        }

    public function webCarsist()
    {
       $data = array();
        $model = array();
    //get current date and time
          $curDt = Carbon::now();
          $frmdt  = $curDt->format('m/d/Y'); //current from date
          $toDat = $curDt->addDays(1);
          $formatToDat = $toDat->format('m/d/Y'); //to date
          
          // $vehcleType = $request->input('vehicle_type');
          // $brandType = $request->input('brand_type');
          $frmDate = $frmdt;
          $toDate = $formatToDat;
          $pickupTime = "10:00";
          $returnTime = "10:00";
          $curType = "1";
         

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
          // $data['City'] = $resCity->city_name;
          // $data['city_id'] = $resCity->city_id;
          // $data['Location'] = $resLoc->location_name;
          // $data['location_id'] = $resLoc->city_loc_id;
          // Session::put('days',$days);
          // Session::put('city_name',$resCity->city_name);
          // Session::put('location_name',$resLoc->location_name);
   
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
                  $maker=Maker::where('maker_id',$modList->makers)->first();
                  $car['Maker_name']=@$maker->maker_name;
                  $car['Model_category'] = $modList->category['model_cat_name']??'';
                  $car['Model_available']=$modList->rdy_count;
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
                       $rateType = Mode_rate::where('model_id','=',$modList->model_number)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->model_number)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
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
              return $data;
    }
  }

    
    public function newsletterSend(Request $request)
    {

        $subscriberEmail = $request->newsletter_email;
        $custMail = "jizjincy70@gmail.com";
       
        $data = array('subscriber_email'=>$subscriberEmail,'to_mail'=>$custMail);
            //  Mail::send('front-end/mail-templates/newsletter-template', $data, function($message) use ($data){
            //      $message->to($data['to_mail'], 'RENT SOLUTIONS')->subject
            //         ('Newsletter Subscription');
            //     $message->from('testdeveloper@webprojects.hexeam.in','RENT SOLUTIONS');
            // });
             
        return back()->with('status','Newsletter subscription successfull.');
    }





























}
