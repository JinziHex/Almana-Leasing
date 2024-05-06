<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Model_image;
use App\Models\Device;
use App\Models\Mode_rate;
use App\Models\Modal;
use App\Helpers\Helper;
use App\Models\City;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Model_specification;
use App\Models\City_location;
use App\Models\Customer;
use App\Models\Api\Notification;
use App\Models\Setting;
use  Carbon;

class ReservationController extends Controller
{
    public function getReservations(Request $request)
    {
    	$data = array();
        $reserve = array();
        
        
        try
        	{
        		$custId = $request->input('customer_id');
        		$curDate = Carbon\Carbon::now();
        		$fetchBooking = Booking::where('book_cust_id','=',$custId)->where('book_to_date','>',$curDate)->where('book_status','!=',['5','1','3'])->orderBy('book_id','DESC')->get();
        		if(!$fetchBooking->isEmpty())
        		{
        		
        			foreach($fetchBooking as $fetchBookings)
	    			{
	    				$book = array();
	    				
	    				$book['Reference_id'] = $fetchBookings->book_ref_id;
	    				$book['From_date'] = $fetchBookings->book_from_date;
	    				$book['To_date'] = $fetchBookings->book_to_date;
	    				$book['Pickup_Time'] = date('g:i A',strtotime($fetchBookings->book_pickup_time));
	    				$book['Return_Time'] = date('g:i A',strtotime($fetchBookings->book_return_time));
	    				$book['First_name'] = @$fetchBookings->book_bill_cust_fname;
                        $book['Last_name'] = @$fetchBookings->book_bill_cust_lname;
                        $book['Mobile_Number'] = @$fetchBookings->book_bill_cust_mobile;
                        $book['Qatar Id'] = @$fetchBookings->book_bill_cust_qatar_id;
                        $book['Zipcode'] =  strval(@$fetchBookings->book_bill_cust_zipcode);
                        $book['Date_of_Birth'] = @$fetchBookings->book_bill_cust_dob;
                        $book['Passport_Number'] = @$fetchBookings->cust_passport;
        				$book['booking_date']=date('Y-m-d',strtotime(@$fetchBookings->created_at));
        				$book['currency']="QAR";
	    				$book['Address_line_1'] = $fetchBookings->book_bill_cust_address_1;
	    				$book['Address_line_2'] = $fetchBookings->book_bill_cust_address_2;
	    				$book['Country_Id'] = $fetchBookings->book_bill_cust_nationality;
	    				$book['Country_Name'] = @$fetchBookings->country['country_name'];
	    				$book['City_Id'] = $fetchBookings->book_bill_cust_city;
	    				$book['City'] = @$fetchBookings->city['city_name'];
	    				$book['City_Arb'] = @$fetchBookings->city['ar_city_name'];
	    				$book['Location_Id'] = $fetchBookings->book_bill_cust_location;
	    				$book['Location'] = @$fetchBookings->state['location_name'];
	    				$book['Location_Arb'] = @$fetchBookings->state['ar_location_name'];
	    				$book['Maker'] = @$fetchBookings->model->maker['maker_name'];
	    				$book['Model'] = @$fetchBookings->model->modal_name;
	                    $getImg = Model_image::where('model_id','=',$fetchBookings->book_car_model)->where('model_image_flag','=',0)->first();
	                     $book['Image'] ='/assets/uploads/models/'.$getImg->model_image; 
	                    $book['Total_days'] = $fetchBookings->book_total_days;
	                    $book['Booking_Status'] = $fetchBookings->status->status;
	    				$book['Daily Rate'] = $fetchBookings->book_daily_rate;
	    				$book['Total Rate'] = $fetchBookings->book_total_rate;
	    				$modalId = $fetchBookings->book_car_model;
	    				if(!$fetchBookings->book_total_days==0)
                        {
                             $modList= Modal::where('modal_id','=',$modalId)->where('active_flag','=',1)->first();
                             
                              $book['Model_info']['Model_Id'] = $modalId;
                             $book['Model_info']['Model_name']=$modList->modal_name;
                             $book['Model_info']['Maker']=$modList->maker->maker_name;
                             $book['Model_info']['Model_category'] = $modList->category->model_cat_name;
                             $book['Model_info']['Model_Available'] = $modList->rdy_count;
                            $modImage = Model_image::where('model_id',$modList->modal_id)->where('model_image_flag','=',0)->first();
                             $book['Model_info']['Model_image'] = '/assets/uploads/models/'.$modImage->model_image;
                            //specifications
                            $resSpec = Model_specification::where('model_id','=',$modList->modal_id)->get();
                            $spec=array();
                              $spec=array();
                      foreach ($resSpec as $resSpecs) {
                        $specComb[0] = @$resSpecs->specs['spec_name'];
                        $specComb[1] = '/assets/uploads/specifications/icons/'.@$resSpecs->specs['spec_icon'];
                        $specComb[2] = @$resSpecs->specs['ar_spec_name'];
                        array_push($spec,$specComb);

                      }
                      $book['Model_info']['specifications'] = $spec;
                      $typoo = Helper::setType($fetchBookings->book_total_days);
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
                      $curType=1;
                      if($curType==1)
                       {
                          $fetchCurrency = Currency::where('currency_id','=',1)->first();
                          $book['Model_info']['Currency_code'] = $fetchCurrency->currency_code;
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
                       $book['Model_info']['Rate_code'] = $rateTypes->rates->rate_type_code;
                       // $car['Total_Rate'] = Helper::showList($days,$rate);
                        $rt = Helper::showList($fetchBookings->book_total_days,$rate);

                       $book['Model_info']['Total_Rate'] = floatval($rt['totValue']);
                       $book['Model_info']['model_year']=@$rateTypes->model_year;

                       $book['Model_info']['Rate_per_day'] = floatval(number_format($rt['perDayRate'], 2, '.', ''));
                       //var_dump($car['Rate_per_day']);
                       $book['Model_info']['Main_Rate']= $mainRat;
                       $book['Model_info']['Offer_Rate'] = $mainOffer;
                       
                        }
                        }
	    				
	    		
	    				array_push($reserve,$book);
	    			}
	    			$data['status'] = "1";
	    			 $data['Reservations'] = $reserve;
	    		}else{
	    			$data['status'] = "0";
	    			$data['message'] ="No reservations found";
	    		}
        		
        		
    			
        		return response($data);
	        }catch (\Exception $e) {
	           $response = ['status' =>"0", 'message' => $e->getMessage()];
	           return response($response);
	        }catch (\Throwable $e) {
	            $response = ['status' =>"0",'message' => $e->getMessage()];

	            return response($response);
	        }
    }
}
