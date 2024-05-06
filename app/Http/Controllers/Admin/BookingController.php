<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Status;
use App\Models\Customer;
use App\Models\Modal;
use App\Helpers\Helper;
use App\Mail\BookingStatus;
use App\Models\Api\Notification;
use App\Models\City;
use App\Models\City_location;
use App\Models\Country;
use App\Models\Device;
use Illuminate\Support\Facades\Redirect;
use Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            try {
                $pageTitle = "Booking";
                $bkDetail = Booking::orderBy('book_id', 'DESC')->paginate(20);
                $bkStatus = Status::orderBy('status_id', 'ASC')->get();
                $custmList = Customer::orderBy('customer_id', 'ASC')->get();
                $bookStatus = Status::orderBy('status_id', 'ASC')->get();
                $bookModel = Modal::orderBy('modal_id', 'ASC')->get();
                return view('admin.elements.booking.index', compact('pageTitle', 'bkDetail', 'bkStatus', 'custmList', 'bookStatus', 'bookModel'));
            } catch (\Exception $e) {
                return Redirect::back()->withErrors(['Something went wrong', $e->getMessage()]);
            } catch (\Throwable $e) {

                return Redirect::back()->withErrors(['Something went wrong', $e->getMessage()]);
            }
        } else {
            return redirect('/login');
        }
    }

    public function view($id)
    {
        if (Auth::check()) {
            try {
                $pageTitle = "View Booking";
                $bkId = Helper::decryptSting($id);
                $bkDetail = Booking::where('book_id', $bkId)->first();
                return view('admin.elements.booking.view', compact('pageTitle', 'bkId', 'bkDetail'));
            } catch (\Exception $e) {
                return Redirect::back()->withErrors(['Something went wrong', $e->getMessage()]);
            } catch (\Throwable $e) {

                return Redirect::back()->withErrors(['Something went wrong', $e->getMessage()]);
            }
        } else {
            return redirect('/login');
        }
    }

    public function status(Request $request)
    {
        if (Auth::check()) {
            try {
                $bkId = $request->input('book_id');
                $status = $request->input('status');
                $bookDetails = Booking::with('model')->where('book_id', $bkId)->first();
                if ($status <= $bookDetails->book_status) {
                    return back()->with('error', 'Booking Status Cannot be changed');
                }
                Booking::where('book_id', $bkId)->update([
                    'book_status' => $request->input('status')
                ]);

             //dd($request->input('status'));
                $custId = $bookDetails->book_cust_id;
                $referenceId = $bookDetails->book_ref_id;
                $custFname = $bookDetails->book_bill_cust_fname;
                $cstlname = $bookDetails->book_bill_cust_lname;
                $bkStatus = $bookDetails->book_status;
                $bkFromDate = $bookDetails->book_from_date;
                $bkToDate = $bookDetails->book_to_date;
                $bkPickup = $bookDetails->book_pickup_time;
                $bkReturn = $bookDetails->book_pickup_time;
                $bkRate = $bookDetails->book_total_rate;
                $bkCity = $bookDetails->book_bill_cust_city;
                $city = City::findOrFail($bkCity);
                $bkCityName = $city->city_name;
                $bkModel = $bookDetails->model->modal_name;
                $bkMaker = $bookDetails->model->maker->maker_name;
                $bkmodelImage = $bookDetails->model->modelImage->model_image;
                $getStatus = Status::where('status_id', '=', $status)->first();
                $statusName = $getStatus->status;
                $custDetls = Customer::where('customer_id', $bookDetails->book_cust_id)->first();
                $custMail = $custDetls->email;
                $notfContent = "Your Booking with Reference Number: " . $referenceId . " is " . $statusName;
                
                //Booking status confirm.FCM reservation api 
                if($request->input('status') == 4)
                {
                     $bookingInfo = Booking::where('book_id','=',$bkId)->first();
                     $customer=Customer::where('customer_id','=',$bookingInfo->book_cust_id)->first();
                       
                    if($customer!=NULL)
                        {
                           
                            
                            $customer_first_name=$customer->cust_fname;
                            $customer_last_name=$customer->cust_lname;
                            $customer_full_name=$customer->cust_fname.' '.$customer->cust_lname;
                            $customer_dob=$customer->cust_dob;
                            $customer_email=$customer->email;
                            $customer_address=$bookingInfo->book_bill_cust_address_1??''.' '.$bookingInfo->book_bill_cust_address_2;
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
                    
                    $country_qry=Country::where('country_id',$customer->cust_nationality)->first();
                    if($country_qry)
                    {
                        $country=$country_qry->country_name;
                        
                    }else{
                        $country = "Not Specified";
                    }
                    
                   
                    if($customer->cust_qatar_id!=NULL)
                    {
                        $id_no=$customer->cust_qatar_id;
                        
                    }
                    else
                    {
                        $id_no=$customer_passport;
                        
                    }
               
               
                $client1 = new \GuzzleHttp\Client();
               
                $api = $client1->get('http://130.61.97.192:201/F_CUSTOMERS?LookupText='.$customer_first_name.'&PageSize=1&Skip=0&FC_MOBILE='.$customer->cust_mobile_number.'&FC_ID_NO='.$id_no);
                
                
                $data = $api->getBody()->getContents();
                $response = json_decode($data, true);
                if($response){
                    $respItems = $response['Items'];
                    
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
                    //dd('test3');
                    
                }
                $modal=Modal::where('modal_id',$bookingInfo->book_car_model)->first();
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
                
                 $client2 = new \GuzzleHttp\Client();
                        $api2 =   $client2->post('http://130.61.97.192:201/Reservation',
                        array(
                            'form_params' => 
                            array(
                               
                              "rsr_book_date"=>date('Y-m-d',strtotime($bookingInfo->created_at))??"2022-10-29",  

                            
                              "rsr_cust_name"=>$customer_full_name, 
                              
                              "rsr_cust_cat_code"=>"1", 
                              "rsr_cust_code"=>$custCode, 
                              
                              "rsr_cust_gender"=>"",
                            
                              "rsr_cust_addr"=>$customer_address??'',  
                              'rsr_cust_dob'=>$customer_dob,
                              
                              "rsr_cust_cat_code "=>"NA",
                              
                              'rsr_customer_passport'=>$customer_passport,
                              
                              'rsr_customer_passport_exp'=>$customer_passport_expiry,
                              
                              'rsr_rent_start_date'=>date('Y-m-d',strtotime($bookingInfo->book_from_date)),
                              
                              'rsr_rent_start_time'=>date('H:i',strtotime($bookingInfo->book_pickup_time)),
                              
                              'rsr_rent_end_date'=>date('Y-m-d',strtotime($bookingInfo->book_to_date)),
                              
                              'rsr_rent_end_time'=>date('H:i',strtotime($bookingInfo->book_return_time)),
                              
                              'rsr_cust_qid'=>$customer->cust_qatar_id,
                              
                              'rsr_cust_qid_exp'=>"2022-11-07",
                              
                              'rsr_rental_days'=>@$bookingInfo->book_total_days,
                              
                              'rsr_rental_amount'=>@$bookingInfo->book_total_rate,
                              
                              'rsr_pickup_location'=>$location,
                            
                              "rsr_tel"=>$customer->cust_mobile_number,          
                            
                              "rsr_email"=>$customer_email,        
                            
                              "rsr_nation"=>$country,      
                            
                              "rsr_cust_id"=>1,
                              
                              "rsr_cust_id_exp"=>"2022-10-29",
                              
                             
                              
                              "rsr_driving_lic_no"=>$bookingInfo->book_bill_cust_lic_number,
                              
                              "rsr_driving_lic_exp"=>date('Y-m-d',strtotime($bookingInfo->book_bill_cust_lic_date)),
                              
                              "rsr_coupon_code"=>$bookingInfo->coupon_code??'',
                              
                              "rsr_coupon_disc"=>@$bookingInfo->coupon_discount,
                              
                              "rsr_act_flag"=>'A',
                            
                              "rsr_rent_date"=>$bookingInfo->book_from_date??"2022-10-29",    
                            
                              "rsr_rent_time"=>date('H:i',strtotime($bookingInfo->book_pickup_time))??"11:30",    
                            
                              "rsr_car_group"=>1,    
                            
                              "rsr_car_make"=>$makerid,    
                            
                              "rsr_car_model"=>$model_number,    
                            
                              "rsr_rent_type"=>'D' ,   
                            
                              "rsr_rent_rate"=>$bookingInfo->book_daily_rate,  
                              
                              'rsr_cust_category'=>1,
                            
                              "rsr_website_booking_ref"=>$referenceId??''
                            )
                        )
                    );
                    
                    
                }
               
                
                //FCM reservation api ends hers

                Notification::create([
                    'customer_id' => $custId,
                    'notification_title' => "Booking Status",
                    'notification_content' => $notfContent,
                    'notification_status' => 1
                ]);

              //send mail for all status change
              
        $data = array('customer_fname'=>$custFname,'customer_lname'=>$cstlname,
             'booking_ref_id'=>$referenceId,'booking_status'=>$statusName,'to_mail'=>$custMail,'booking_from_date'=>$bkFromDate,'booking_to_date'=>$bkToDate,'booking_pickup_time'=>$bkPickup,'booking_return_time'=>$bkReturn,'booking_total'=>$bkRate,
            'booking_city_name'=>$bkCityName,'booking_model_name'=>$bkModel,
             'booking_maker_name'=>$bkMaker,'booking_model_image'=>$bkmodelImage);
             Mail::send('front-end/mail-templates/booking-template', $data, function($message) use ($data){
            $message->to($data['to_mail'],'Almana Leasing')->subject
                     ('BOOKING INFORMATION');
            $message->cc('info@almanaleasing.com', 'Almana Leasing');
            $message->from('reservations@almanaleasing.com','ALMANA LEASING BOOKING INFORMATION');
             });
             
            /*  Mail::send('front-end/mail-templates/booking-template', $data, function($message) use ($data){
            $message->to('info@almanaleasing.com','Almana Leasing')->subject
                     ('BOOKING INFORMATION');
            $message->from('reservations@almanaleasing.com','ALMANA LEASING BOOKING INFORMATION');
             });*/
                           //push notification
                $devices = Device::where('customer_id', $bookDetails->customer->customer_id)->get();
                
                if($status != 5)
                {
                    foreach ($devices as $device) {
                         $notification = [];
                        $title = "Booking " . $getStatus->status;
                        $body = "Booking Status for booking id " . $referenceId . " has been " .  $getStatus->status;
                        $clickAction = "ReservationFragment";
                        $type = "Booking";
                        $notification[] = Helper::customerNotification($device->device_token, $title, $body, $clickAction, $type);
                        $data['notification'] = $notification;
                    }
                }else{
                    foreach ($devices as $device) {
                         $notification = [];
                        $title = "Booking " . $getStatus->status;
                        $body = "Booking Status for booking id " . $referenceId . " has been " .  $getStatus->status;
                        $clickAction = "RentalHistoryFragment";
                        $type = "History";
                        $notification[] = Helper::customerNotification($device->device_token, $title, $body, $clickAction, $type);
                        $data['notification'] = $notification;
                    }
                }
                
                

                return back()->with('status', 'Booking Status Changed');
            } catch (\Exception $e) {
                return Redirect::back()->withErrors(['Something went wrong', $e->getMessage()]);
            } catch (\Throwable $e) {

                return Redirect::back()->withErrors(['Something went wrong', $e->getMessage()]);
            }
        } else {
            return redirect('/login');
        }
    }

    public function statusNotification(Request $request)
    {
        $book = Booking::where('book_id', $request->book_id)->first();
        $status = Status::where('status_id', $request->status_id)->first();
        //push notification
        $devices = Device::where('customer_id', $book->customer->customer_id)->get();

        foreach ($devices as $device) {
            $title = "Booking " . $status->status;
            $body = "Booking for booking id " . $book->book_id . " has " .  $status->status;
            $clickAction = "Book Car";
            $type = "Booking";
            $response = Helper::customerNotification($device->device_id, $title, $body, $clickAction, $type);
            return response($response);
        }
    }

    public function filter(Request $request)
    {
        try {
            $pageTitle = "Booking";
            $bkDetail = Booking::orderBy('book_id', 'DESC')->get();
            $bkStatus = Status::orderBy('status_id', 'ASC')->get();
            $custmList = Customer::orderBy('customer_id', 'ASC')->get();
            $bookStatus = Status::orderBy('status_id', 'ASC')->get();
            $bookModel = Modal::orderBy('modal_id', 'ASC')->get();

            $refId = $request->input('reference_id');
            $frmDt = $request->input('from_date');
            $dtFrmAlt = Carbon\Carbon::parse($frmDt)->format('Y/m/d');
            $toDt  = $request->input('to_date');
            $dtToAlt = Carbon\Carbon::parse($toDt)->format('Y/m/d');
            $custId = $request->input('customers');
            $bkStatusss = $request->input('book_status');
            $modelss = $request->input('book_models');

            $query = Booking::select('*');

            if ($refId) {

                $query = $query->where('book_ref_id', '=', $refId);
            }
            if ($custId) {

                $query = $query->where('book_cust_id', '=', $custId);
            }
            if ($bkStatusss) {

                $query = $query->where('book_status', '=', $bkStatusss);
            }
            if ($dtFrmAlt) {

                $query = $query->whereDate('book_from_date', '>=', $dtFrmAlt);
            }
            if ($dtToAlt) {

                $query = $query->whereDate('book_to_date', '<=', $dtToAlt);
            }

            if ($modelss) {

                $query = $query->where('book_car_model', '=', $modelss);
            }

            $data['result'] = $query->paginate(10);


            // $data['count'] = count($res);
            $data['status'] = Status::orderBy('status_id', 'ASC')->get();
            return view('admin.elements.booking.search', compact('pageTitle', 'bkDetail', 'bkStatus', 'custmList', 'bookStatus', 'bookModel', 'refId', 'frmDt', 'toDt', 'custId', 'bkStatusss', 'modelss'), $data);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['Something went wrong', $e->getMessage()]);
        } catch (\Throwable $e) {

            return Redirect::back()->withErrors(['Something went wrong', $e->getMessage()]);
        }
    }
    public function mailTest()
    {
        $custMail="dipin.kp@hexeam.co.in";
          $data = array('to_mail'=>$custMail);
             Mail::send('front-end/mail-templates/test-mail', $data, function($message) use ($data){
            $message->to($data['to_mail'],'Almana Leasing')->subject
                     ('BOOKING INFORMATION');
            $message->cc('dipinpnambiar@gmail.com', 'Almana Leasing');
            $message->from('reservations@almanaleasing.com','ALMANA LEASING BOOKING INFORMATION');
             });
        
    }
}
