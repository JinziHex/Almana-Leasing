<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Model_image;
use  Carbon;

class RentController extends Controller
{
    public function rentHistory(Request $request)
    {
    	$data = array();
        $rent = array();
        try
        	{
    			$custId = $request->input('customer_id');
                $parseInt = (int)$custId;
                $curDate = Carbon\Carbon::now();
                
    			$fetchBooking = Booking::where('book_cust_id','=',$parseInt)->Where('book_to_date','<=',$curDate)->OrWhereIn('book_status',['5','6'])->orderBy('book_id','DESC')->get();
                
                if(!$fetchBooking->isEmpty())
                {
        			foreach($fetchBooking as $fetchBookings)
        			{
        				$book = array();
        				$book['Reference_id'] = $fetchBookings->book_ref_id;
        				$book['From_date'] = $fetchBookings->book_from_date;
        				$book['To_date'] = $fetchBookings->book_to_date;
        				$book['Country_Name'] = @$fetchBookings->country['country_name']??'';
	    				$book['City'] = @$fetchBookings->city['city_name']??'';
	    				$book['City_Arb'] = @$fetchBookings->city['ar_city_name']??'';
	    				$book['Location'] = @$fetchBookings->state['location_name']??'';
	    				$book['Location_Arb'] = @$fetchBookings->state['ar_location_name']??'';
        				$book['Maker'] = @$fetchBookings->model->maker->maker_name;
        				$book['Model'] = @$fetchBookings->model->modal_name;
        				$book['currency']="QAR";
        				$book['First_name'] = @$fetchBookings->book_bill_cust_fname;
                        $book['Last_name'] = @$fetchBookings->book_bill_cust_lname;
                        $book['Mobile_Number'] = @$fetchBookings->book_bill_cust_mobile;
                        $book['Qatar Id'] = @$fetchBookings->book_bill_cust_qatar_id;
                        $book['Zipcode'] =  @$fetchBookings->book_bill_cust_zipcode;
                        $book['Date_of_Birth'] = @$fetchBookings->book_bill_cust_dob;
        				$book['booking_date']=date('Y-m-d',strtotime(@$fetchBookings->created_at));
                        $getImg = Model_image::where('model_id','=',$fetchBookings->book_car_model)->where('model_image_flag','=',0)->first();
                        $book['Image'] ='/assets/uploads/models/'.$getImg->model_image; 
                        $book['Total_days'] = $fetchBookings->book_total_days;
                        $book['Booking_status'] = $fetchBookings->status['status'];
        				// $book['Daily Rate'] = $fetchBookings->book_daily_rate;
        				// $book['Total Rate'] = $fetchBookings->book_total_rate;
        				array_push($rent,$book);
        			}
                    $data['status'] = "1";
                     $data['Rent History'] = $rent;
                }else{
                    $data['status'] = "0";
                    $data['message'] ="No History Found";
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
}
