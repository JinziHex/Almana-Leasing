<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Crypt;
use Auth;
use App\Models\Feedback;
use App\Models\City;
use App\Models\City_location;
use App\Models\Modal;
use App\Models\Maker;
use App\Models\Booking;
use App\Models\Model_category;
use App\Models\Rate_type;
use App\Models\Mode_rate;
use App\Models\Model_image;
use App\Models\Specification;

use App\Models\Setting;
use App\Models\Model_specification;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;
use  Carbon\Carbon;
use App\Helpers\Helper;
use Session;

class UserHistoryController extends Controller
{
    public function getRentalHistory()
    {
		if (Auth::guard('main_customer')->check()) {
			$custId = Auth::guard('main_customer')->user()->customer_id;
			//dd($custId);
			$curDate = Carbon::now();
			//dd($curDate);
			$fetchCity = City::orderBy('city_id','DESC')->get();
			
			$fetchBooking = Booking::where('book_cust_id','=',$custId)->Where('book_to_date','<=',$curDate)->OrWhereIn('book_status',['5','6'])->orderBy('book_id','DESC')->get();
    		return view('front-end.elements.user.rental-history',compact('fetchBooking','fetchCity'));
    	}else{
    		return redirect('/');
    	}
    }

    public function getReservations()
    {
        if (Auth::guard('main_customer')->check()) {
            $date = date('m');
            //dd(strlen($date));
           /* $x=date('d',strtotime(Booking::where('book_ref_id','=','202211249')->first()->book_from_date));
            if($date<10)
            {
                dd('less than 10');
            }
            else
            {
                 dd('more than 10');
                
                
            }*/
            $custId = Auth::guard('main_customer')->user()->customer_id;
            $curDate = Carbon::now();
            $fetchCity = City::orderBy('city_id','DESC')->get();
            $fetchLocation = City_location::orderBy('city_loc_id','DESC')->get();
            $fetchCarList = $this->webCarsist();
            $fetchBooking = Booking::where('book_cust_id','=',$custId)->where('book_to_date','>',$curDate)->where('book_status','!=',['5','1','3'])->orderBy('book_id','DESC')->get();
            return view('front-end.elements.user.reservation',compact('fetchBooking','fetchCity','fetchCarList','fetchLocation'));
        }else{
            return redirect('/');
        }
    }

    public function cancelBooking($id)
    {
        $bookId = Crypt::decryptString($id);
        $curDate = Carbon::now();
        $getBookingData = Booking::where('book_id','=',$bookId)->first();
        $cretdAt = $getBookingData->created_at;
        $addDayss = $cretdAt->addDays(1);
        
       
        if($curDate<=$addDayss)
        {
            Booking::where('book_id','=',$bookId)->update([
                    'book_status' => 5,
                    'active_flag' => 0

                ]);
           return redirect()->back()->with('cancel-success','Cancelled Booking');
           
            }else{
                 
 return redirect()->back()->with('cancel-error','Time Exceeded. Cannot cancel booking.');
            }
            exit();

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
                  $car['Model_category'] = $modList->category->model_cat_name ?? 'Not Specified';
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
  public function getTotalRate()
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
        /*$ccoupon=CustomerCoupon::where('customer_id',Auth::guard('main_customer')->user()->id)->where('coupon_id',@$coupon->first()->id);
        if($ccoupon->exists())
        {
          $ccoupon->delete();
        }*/

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
  function getModelRate2(Request $request)
  {
       
       
      //dd($request->input('city_loc_id'));
      $id = $request->id;
      $bid = $request->bid;
      //dd(Helper::checkOffer(56,17));
      if(Session::has('cur_type'))
      {    
        $fetcCurrency = Currency::orderBy('currency_id','DESC')->get();
        $fetchCity = City::orderBy('city_id','DESC')->get();
        
        $vehicleMaker = Maker::where('maker_name','!=','Not Defined')->orderBy('maker_id','DESC')->get();
        $data = array();
        $model = array();
  
     /* if(!Session::has('location'))
      {*/
      //dd($request->input('city_loc_id'));
          $locId = $request->input('city_loc_id')??Session::get('location');
          //dd($locId);
          $cityId = $request->input('city_id')??Session::get('city');
          $frmDate = $request->input('from_date')??Session::get('fromdate');
          $toDate = $request->input('to_date')??Session::get('todate');
          $pickupTime = $request->input('pickup_time')??Session::get('pickupTime');
          $returnTime = $request->input('return_time')??Session::get('returnTime');
          $curType = Session::get('cur_type');
          Session::put('location',$locId);
          Session::put('city',$cityId);
          Session::put('fromdate',$frmDate);
          Session::put('todate',$toDate);
          Session::put('pickupTime',$pickupTime);
          Session::put('returnTime',$returnTime);
          Session::put('currency_type',$curType);

     /* }else{
          $locId = Session::get('location');
          $cityId = Session::get('city');
          $frmDate =Session::get('fromdate');
          $toDate = Session::get('todate');
          $pickupTime = Session::get('pickupTime');
          $returnTime = Session::get('returnTime');
          $curType = Session::get('currency_type'); 
          
      }*/


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
          if($totMins > 4 && $diff <= 12  && $diffDays2 >= 1)
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
          //dd(Session::get('city_name'));
          Session::put('location_name',@$resLoc->location_name);
           $model_images=Model_image::all();
    foreach($model_images as $image) {
        $model_image_ids[] = $image->model_id;
    }
   //dd($model_image_ids);
          if(!$days==0)
            {
              
                
                $modList= Modal::where('modals.modal_name','!=',NULL)->where('modal_id',$request->model_id)->where('modals.active_flag','=',1)->whereIn('modal_id',$model_image_ids)->orderBy('modals.modal_id','DESC')->get();
                        //dd('TEST');
                        //dd($modList);
              
             
              $car=array();
              $spec=array();
              $cat_ids=array();
              foreach ($modList as $modList) { 
                  $modalId = $modList->modal_id;
                  $car['Model_id'] = $modList->modal_id;
                  $car['Model_name']=$modList->modal_name;
                  $maker=Maker::where('maker_id',$modList->makers)->first();
                  $car['Maker_name']=@$maker->maker_name;
                  $car['Model_category'] = $modList->category->model_cat_name;
                  array_push($cat_ids,$modList->category->model_cat_id);
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
                      $specification=Specification::where('spec_id',$resSpecs->spec_id)->first();
                    
                    // if($specification->active_flag==1)
                    // {
                    //     $gtspec['Spec_name'] = $resSpecs->specs['spec_name'];
                    //    $gtspec['Spec_Image'] = $resSpecs->specs['spec_icon'];
                    //    array_push($spec,$gtspec); 
                    // }
                   
                  }
                  $car['specifications'] = $spec;
                  //dd($car['specifications']);
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
                //dd($model);
              $data['status']=1;
              $data['Models'] = $model;
                return response()->json(['status'=>1,'data'=>$data]);
            
            }else{
             if(is_null($model)){
              $data['status']=0;
              $data['message'] = "No Cars available";
              return response()->json(['status'=>0,'data'=>$data]);
             }
              
            }
           
          }else{
             $data['status']=0;
              $data['message'] = "No Cars available";
              return response()->json(['status'=>0,'data'=>$data]);
          }
    }
  
}
