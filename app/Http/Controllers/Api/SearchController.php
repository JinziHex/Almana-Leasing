<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modal;
use App\Models\Rate_type;
use App\Models\Mode_rate;
use App\Models\Model_image;
use App\Models\City;
use App\Models\Currency;
use App\Models\Model_specification;
use App\Models\City_location;
use App\Coupon;
use App\CustomerCoupon;
use Illuminate\Support\Facades\DB;
use Crypt;
use App\Helpers\Helper;
use App\Models\MstAds;
use Auth;
use  Carbon\Carbon;
use Validator;

class SearchController extends Controller
{
    function array_sort($array, $on,$order=SORT_ASC){

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
            $new_array[] = $array[$k];
        }
    }

    return $new_array;
}
    public function search(Request $request)
    {
    	$data = array();
      $model = array();
      try
      {
          
          $vehcleType = $request->input('vehicle_type');
          $brandType = $request->input('brand_type');
          
          $locId = $request->input('city_loc_id');
          $cityId = $request->input('city_id');
    	  $frmDate = $request->input('from_date');
    	  $toDate = $request->input('to_date');
          $curType = $request->input('cur_type'); //default currency value of qatar riyal is set to 0
          $resCity =City::where('city_id','=',$cityId)->first(); //Get City
          $resLoc = City_location::where('city_loc_id','=',$locId)->first(); //Get Location
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
            $diff = $parsePickTime->diffInHours($parseRetTime)+1;
        //   $combinedfrom = date('Y-m-d H:i:s', strtotime("$frmDate $pickTime"));
        //   $combinedto = date('Y-m-d H:i:s', strtotime("$toDate $retTime"));
        //   $parsecombinefrom = Helper::parseCarbon($combinedfrom); 
        //   $parsecombineto = Helper::parseCarbon($combinedto); 
          $diffDays2 = $parseFrmDt->diffInDays($parseToDate);
          $mins            = $parseRetTime->diffInMinutes($parsePickTime, true);
          $totMins = ($mins/60);
          
          //get number of days
          if($totMins > 4 && $diff <= 12  && $diffDays2 >= 1)
          {
            $days=$secndParsFrm->diffInDays($secndParseTo)+1;  
          }else{
              $days=$secndParsFrm->diffInDays($secndParseTo); 
              if($diff>=4)
              {
                  $days=$secndParsFrm->diffInDays($secndParseTo)+1; 
                  
              }
             
          }
          
          $data['Days'] = $days;
          $data['City'] = $resCity->city_name;
          $data['City_Ar'] = $resCity->ar_city_name;
          $data['Location'] = $resLoc->location_name;
          $data['Location_Ar'] = $resLoc->ar_location_name;
          
           $model_images=Model_image::all();
    foreach($model_images as $image) {
        $model_image_ids[] = $image->model_id;
    }
          
              

          if(!$days==0)
            {
              if (!$vehcleType==0 && !$brandType==0) { //if both vehcile type and brand is selected

               if($vehcleType!=13 && $brandType!=29)
                {
                
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$vehcleType)->where('modals.makers','=',$brandType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }
                else
                {
                     if($vehcleType==13 && $brandType!=29)
                     {
                         $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.makers','=',$brandType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                     }
                      else if($vehcleType!=13 && $brandType==29)
                     {
                         $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$vehcleType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                     }
                     else
                     {
                          $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$vehcleType)->where('modals.makers','=',$vehcleType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                         
                     }
                         
                   
                
                  
                }
                
              }elseif(!$vehcleType==0 && $brandType==0) //if vehice type only is selected
              {

                if(!$vehcleType==0 && $vehcleType!= 13){
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$vehcleType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }else{
                
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }
              }elseif($vehcleType==0 && !$brandType==0) //if braND alone is selected
              {
                if(!$brandType==0  && $brandType!=29){

                   $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.makers','=',$brandType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
               
                }else{
                  
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
               
                }
              }else{ //if not filter is selected
                
                /*$modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();*/
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)
                        ->whereIn('modal_id',$model_image_ids)
                        ->orderBy('modals.modal_id','DESC')->get();
                        //dd('hii');
              }
              $car=array();
              foreach ($modList as $modList) { 
                  $modalId = $modList->modal_id;
                  $car['Model_Id'] = $modalId;
                  $car['Model_name']=$modList->modal_name;
                  $car['Maker']=$modList->maker->maker_name;
                  $car['Model_category'] = $modList->category->model_cat_name;
                  $car['Model_Available'] = $modList->rdy_count;
                  //image
                  $modImage = Model_image::where('model_id',$modList->modal_id)->where('model_image_flag','=',0)->get();
                      
                      foreach($modImage as $modImages)
                      {
                      $car['Model_image'] = '/assets/uploads/models/'.$modImages->model_image;
                      }
                    //specifications
                    $resSpec = Model_specification::where('model_id','=',$modList->modal_id)->get();
                    $spec=array();
                  foreach ($resSpec as $resSpecs) {
                    $specComb[0] = $resSpecs->specs['spec_name'];
                    $specComb[1] = '/assets/uploads/specifications/icons/'.$resSpecs->specs['spec_icon'];
                     $specComb[2] = $resSpecs->specs['ar_spec_name'];
                    array_push($spec,$specComb);

                  }
                  $car['specifications'] = $spec;
                  $typoo = Helper::setType($days);
                  //rate
                  /*if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }*/
                   if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->model_number)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->model_number)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }
               
                   foreach ($rateType as $rateTypes) {
                    
                      $fetchrate = $rateTypes->rate; //get rate from the table //rate
                      $fetchOfferRate = Helper::checkOffer($rateTypes->model_rate_id,$modList->modal_id); //get offer rate from table;
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

                       $car['Total_Rate'] = (float)$rt['totValue'];

                       $car['Rate_per_day'] = (float)number_format($rt['perDayRate'], 3, '.', '');
                       $car['Main_Rate']= $mainRat;
                       $car['Offer_Rate'] = $mainOffer;
                       
                     array_push($model,$car); 
                   
                     }
                }
             if($request->input('sort_type'))
             {
              if($request->input('sort_type')==1)
              {
                $model = $this->array_sort($model,'Offer_Rate', SORT_ASC);
              }
              if($request->input('sort_type')==2)
              {
                $model= $this->array_sort($model,'Offer_Rate', SORT_DESC);
              }
             }
              $data['status'] = 1;
              $data['Models'] = $model;
                 
            }else{
              $data['status'] = 0;
              $data['message'] = "No Cars available";
            }
            return response($data);
        }catch (\Exception $e) {
           $response = ['status' => false, 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => 'false','message' => $e->getMessage()];
            return response($response);
        }
        
    	
   
    }
    
    
    
    public function webCarList(Request $request)
    {
       
    	$data = array();
      $model = array();
      try
      {
          
          $vehcleType = $request->input('vehicle_type');
          $brandType = $request->input('brand_type');
          
          $locId = $request->input('city_loc_id');
          $cityId = $request->input('city_id');
    	  $frmDate = $request->input('from_date');
    	  $toDate = $request->input('to_date');
          $curType = $request->input('cur_type'); //default currency value of qatar riyal is set to 0
          $resCity =City::where('city_id','=',$cityId)->first(); //Get City
          $resLoc = City_location::where('city_loc_id','=',$locId)->first(); //Get Location
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
            $diff = $parsePickTime->diffInHours($parseRetTime)+1;
        //   $combinedfrom = date('Y-m-d H:i:s', strtotime("$frmDate $pickTime"));
        //   $combinedto = date('Y-m-d H:i:s', strtotime("$toDate $retTime"));
        //   $parsecombinefrom = Helper::parseCarbon($combinedfrom); 
        //   $parsecombineto = Helper::parseCarbon($combinedto); 
          $diffDays2 = $parseFrmDt->diffInDays($parseToDate);
          $mins            = $parseRetTime->diffInMinutes($parsePickTime, true);
          $totMins = ($mins/60);
          
          //get number of days
          if($totMins > 4 && $diff <= 12  && $diffDays2 >= 1)
          {
            $days=$secndParsFrm->diffInDays($secndParseTo)+1;  
          }else{
              $days=$secndParsFrm->diffInDays($secndParseTo); 
              if($diff>=4)
              {
                  $days=$secndParsFrm->diffInDays($secndParseTo)+1; 
                  
              }
             
          }
          
          $data['Days'] = $days;
          $data['City'] = $resCity->city_name;
          $data['City_Ar'] = $resCity->ar_city_name;
          $data['Location'] = $resLoc->location_name;
          $data['Location_Ar'] = $resLoc->ar_location_name;
          
           $model_images=Model_image::all();
    foreach($model_images as $image) {
        $model_image_ids[] = $image->model_id;
    }
          
              

          if(!$days==0)
            {
              if (!$vehcleType==0 && !$brandType==0) { //if both vehcile type and brand is selected

               if($vehcleType!=13 && $brandType!=29)
                {
                
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$vehcleType)->where('modals.makers','=',$brandType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }
                else
                {
                     if($vehcleType==13 && $brandType!=29)
                     {
                         $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.makers','=',$brandType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                     }
                      else if($vehcleType!=13 && $brandType==29)
                     {
                         $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$vehcleType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                     }
                     else
                     {
                          $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$vehcleType)->where('modals.makers','=',$vehcleType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                         
                     }
                         
                   
                
                  
                }
                
              }elseif(!$vehcleType==0 && $brandType==0) //if vehice type only is selected
              {

                if(!$vehcleType==0 && $vehcleType!= 13){
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.modal_category','=',$vehcleType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }else{
                
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->orderBy('modals.modal_id','DESC')->get();
                }
              }elseif($vehcleType==0 && !$brandType==0) //if braND alone is selected
              {
                if(!$brandType==0  && $brandType!=29){

                   $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.makers','=',$brandType)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
               
                }else{
                  
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();
               
                }
              }else{ //if not filter is selected
                
                /*$modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                        $query->select('model_id')->from('model_images');
                        })->orderBy('modals.modal_id','DESC')->get();*/
                  $modList= Modal::where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)
                        ->whereIn('modal_id',$model_image_ids)
                        ->orderBy('modals.modal_id','DESC')->get();
                        //dd('hii');
              }
              $car=array();
              foreach ($modList as $modList) { 
                  $modalId = $modList->modal_id;
                  $car['Model_Id'] = $modalId;
                  $car['Model_name']=$modList->modal_name;
                  $car['Maker']=$modList->maker->maker_name;
                  $car['Model_category'] = $modList->category->model_cat_name;
                  $car['Model_Available'] = $modList->rdy_count;
                  //image
                  $modImage = Model_image::where('model_id',$modList->modal_id)->where('model_image_flag','=',0)->get();
                      
                      foreach($modImage as $modImages)
                      {
                      $car['Model_image'] = '/assets/uploads/models/'.$modImages->model_image;
                      }
                    //specifications
                    $resSpec = Model_specification::where('model_id','=',$modList->modal_id)->get();
                    $spec=array();
                  foreach ($resSpec as $resSpecs) {
                    $specComb[0] = $resSpecs->specs['spec_name'];
                    $specComb[1] = '/assets/uploads/specifications/icons/'.$resSpecs->specs['spec_icon'];
                     $specComb[2] = $resSpecs->specs['ar_spec_name'];
                    array_push($spec,$specComb);

                  }
                  $car['specifications'] = $spec;
                  $typoo = Helper::setType($days);
                  //rate
                  /*if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->modal_id)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }*/
                   if (in_array(4, $typoo) || in_array(5, $typoo) || in_array(6, $typoo) || in_array(7, $typoo) || in_array(8, $typoo))
                  {
                       $rateType = Mode_rate::where('model_id','=',$modList->model_number)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }else{
                     $rateType = Mode_rate::where('model_id','=',$modList->model_number)->where('maker_id','=',$modList->makers)->where('rate_type_id','=',$typoo)->get(); 
                  }
               
                   foreach ($rateType as $rateTypes) {
                    
                      $fetchrate = $rateTypes->rate; //get rate from the table //rate
                      $fetchOfferRate = Helper::checkOffer($rateTypes->model_rate_id,$modList->modal_id); //get offer rate from table;
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

                       $car['Total_Rate'] = (float)$rt['totValue'];

                       $car['Rate_per_day'] = (float)number_format($rt['perDayRate'], 3, '.', '');
                       $car['Main_Rate']= $mainRat;
                       $car['Offer_Rate'] = $mainOffer;
                       
                     array_push($model,$car); 
                   
                     }
                }
             if($request->input('sort_type'))
             {
              if($request->input('sort_type')==1)
              {
                $model = $this->array_sort($model,'Offer_Rate', SORT_ASC);
              }
              if($request->input('sort_type')==2)
              {
                $model= $this->array_sort($model,'Offer_Rate', SORT_DESC);
              }
             }
              $data['status'] = 1;
              $data['Models'] = $model;
                 
            }else{
              $data['status'] = 0;
              $data['message'] = "No Cars available";
            }
            return response($data);
        }catch (\Exception $e) {
           $response = ['status' => false, 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => 'false','message' => $e->getMessage()];
            return response($response);
        }
        
    	
   
    }
    public function getAvailableCoupons()
    {
        try{
            $coupons=Coupon::where('start_date', '<=', date("Y-m-d"))
            ->where('end_date', '>=', date("Y-m-d"))->where('is_active','=',1)->get()->toArray();
            foreach($coupons as $coupon)
            {
                if($coupon['discount_type']==1)
                {
                    $coupon['discount_name']="Price";
                }
                if($coupon['discount_type']==2)
                {
                    $coupon['discount_name']="Percentage";
                }
                 //array_push($coupon,$discount_name); 
            }
            if(count($coupons)>0)
            {
                $status=1;
                $message="Coupons fetched";
            }
            else
            {
                $status=0;
                $message="No coupons available now";
                
            }
            $currency = "QAR";
            $data['status']=$status;
            $data['currency']=$currency;
            $data['message']=$message;
            $data['coupons']=$coupons;
           
            
            
             return response($data);
            
        }
    catch (\Exception $e) {
           $response = ['status' => false, 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => 'false','message' => $e->getMessage()];
            return response($response);
        }
    }
    public function applyCoupon(Request $request)
    {
        try
        {
      $total_amount=$request->total_amount;
      //return $total_amount;
     
      $coupon_code=$request->coupon_code;
      $custmrId = $request->customer_id;
      
      //return $total_amount;
      $coupon=Coupon::where('coupon_code',$coupon_code);
      if(!$coupon->exists())
      {
       return response()->json(['status'=>0,'message'=>'Invalid coupon code','total_rate'=>floatval($total_amount)]);
      }
      else
      {
        if(date('Y-m-d')>$coupon->first()->end_date)
        {
          return response()->json(['status'=>5,'message'=>'Coupon Expired','total_rate'=>floatval($total_amount)]);
        }
        if($coupon->first()->minimum_order_amount>=$total_amount)
        {
          return response()->json(['status'=>6,'message'=>'Not Applicable to current amount','total_rate'=>floatval($total_amount)]);
        }
        
      }
      $customer_coupon=CustomerCoupon::where('customer_id',$custmrId)->where('coupon_id',@$coupon->first()->id);
      if($customer_coupon->exists())
      {
          if($customer_coupon->first()->is_applied==1)
          {
               return response()->json(['status'=>1,'message'=>'You can not apply this coupon code.This coupon already applied before','total_rate'=>floatval($total_amount)]);
              
          }
          else
          {
        if($coupon->first()->discount_type==1)
        {
          $total_amount_applied=$total_amount-$coupon->first()->discount_value;
          //return $total_amount_applied;
        }
        if($coupon->first()->discount_type==2)
        {
          $total_amount_applied=$total_amount-($total_amount*($coupon->first()->discount_value/100));
          //return $total_amount;
        }
      //return $total_amount_applied;
        return response()->json(['status'=>2,'message'=>'Coupon  code applied successfully','total_rate'=>floatval($total_amount_applied)]);
      
              
          }
       
      }
      else
      {
        $customer_coupon=new CustomerCoupon();
        $customer_coupon->coupon_id=$coupon->first()->id;
        $customer_coupon->customer_id=$custmrId;
        $customer_coupon->is_applied=0;
        $customer_coupon->save();
        if($coupon->first()->discount_type==1)
        {
          $total_amount_applied=$total_amount-$coupon->first()->discount_value;
        }
        if($coupon->first()->discount_type==2)
        {
            //return $total_amount;
          $total_amount_applied=$total_amount-($total_amount*$coupon->first()->discount_value)/100;
        }
       
        return response()->json(['status'=>2,'message'=>'Coupon  code applied successfully','total_rate'=>floatval(number_format($total_amount_applied,2))]);
      }
      return response()->json(['status'=>3,'total_rate'=>$total_amount]);
    
            
        }
        catch (\Exception $e) {
           $response = ['status' => false, 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => false,'message' => $e->getMessage()];
            return response($response);
        }
    }
     public function removeCoupon(Request $request)
    {
         try
        {
      $total_amount=$request->total_amount;
     
      $coupon_code=$request->coupon_code;
      
      $custmrId = $request->customer_id;
      
      //return $total_amount;
      $coupon=Coupon::where('coupon_code',$coupon_code);
     
      $customer_coupon=CustomerCoupon::where('customer_id',$custmrId)->where('coupon_id',@$coupon->first()->id);
        if($customer_coupon->exists())
        {
          $customer_coupon->delete();
        }

      
        if($coupon->first()->discount_type==1)
        {
          $real_amount=$total_amount+@$coupon->first()->discount_value;
        }
        if($coupon->first()->discount_type==2)
        {
          $real_amount=$total_amount*(100/(100-@$coupon->first()->discount_value));
        }
     
       
        return response()->json(['status'=>2,'total_rate'=>number_format($real_amount,2),'message'=>'Coupon has been removed']);
        }
          catch (\Exception $e) {
           $response = ['status' => false, 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => false,'message' => $e->getMessage()];
            return response($response);
        }
     
  
  

    }
 
    
 public function listAds(Request $request)
    {
    	$data = array();
    	try
    	{
    		$data['Ads_List'] = MstAds::orderBy('id','DESC')->get();
    		$data['Image_path'] = "/assets/uploads/ads";
    		$data['status'] = 1;
    		$data['message'] = "Success";
    		return response($data)->setStatusCode(200);
    	}catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];

            return response($response);
        }
    	
    }
    
    

}
