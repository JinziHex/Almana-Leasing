<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Status;
use App\Models\Customer;
use App\Models\Modal;
use App\Helpers\Helper;
use App\Models\Api\Notification;
use App\Models\City;
use Validator;
use Crypt;
use Carbon;
use Auth;
use Mail;

class BookingController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
        	$pageTitle = "Booking";
        	$bkDetail = Booking::orderBy('book_id','DESC')->get();
            $bkStatus = Status::orderBy('status_id','ASC')->get();
            $custmList = Customer::orderBy('customer_id','ASC')->get();
            $bookStatus = Status::orderBy('status_id','ASC')->get();
            $bookModel = Modal::orderBy('modal_id','ASC')->get();
        	return view('admin.elements.booking.index',compact('pageTitle','bkDetail','bkStatus','custmList','bookStatus','bookModel'));
        }else{
            return redirect('/login');
        }
    }

    public function view($id)
    {
        if (Auth::check())
        {
        	$pageTitle = "View Booking";
        	$bkId = Helper::decryptSting($id);
        	$bkDetail = Booking::where('book_id',$bkId)->first();
        	return view('admin.elements.booking.view',compact('pageTitle','bkId','bkDetail'));
        }else{
            return redirect('/login');
        }
    }

    public function status(Request $request)
    {
        if (Auth::check())
        {
            $bkId = $request->input('book_id');
           
            Booking::where('book_id',$bkId)->update([
                'book_status' => $request->input('status')
            ]);
             $bookDetails = Booking::with('model')->where('book_id',$bkId)->first();
             $custId = $bookDetails->book_cust_id;
             $referenceId = $bookDetails->book_ref_id;
             $custFname = $bookDetails->book_bill_cust_fname;
             $cstlname = $bookDetails->book_bill_cust_lname;
             $bkStatus = $bookDetails->book_status;
             $bkFromDate=$bookDetails->book_from_date;
             $bkToDate=$bookDetails->book_to_date;
             $bkPickup=$bookDetails->book_pickup_time;
             $bkReturn=$bookDetails->book_pickup_time;
             $bkRate=$bookDetails->book_total_rate;
             $bkCity=$bookDetails->book_bill_cust_city;
             $city=City::findOrFail($bkCity);
             $bkCityName=$city->city_name;
             $bkModel=$bookDetails->model->modal_name;
             $bkMaker=$bookDetails->model->maker->maker_name;
             $bkmodelImage=$bookDetails->model->modelImage->model_image;
             $getStatus = Status::where('status_id','=',$bkStatus)->first();
             $statusName = $getStatus->status;
             $custDetls = Customer::where('customer_id',$bookDetails->book_cust_id)->first();
             $custMail = $custDetls->email;
             $notfContent = "Your Booking with Reference Number:" .$referenceId. "is" .$statusName;
             Notification::create([
                    'customer_id' => $custId,
                    'notification_title' => "Booking Status",
                    'notification_content' => $notfContent,
                    'notification_status' => 1
                 ]);
             
             $data = array('customer_fname'=>$custFname,'customer_lname'=>$cstlname,
             'booking_ref_id'=>$referenceId,'booking_status'=>$statusName,'to_mail'=>$custMail,'booking_from_date'=>$bkFromDate,'booking_to_date'=>$bkToDate,'booking_pickup_time'=>$bkPickup,'booking_return_time'=>$bkReturn,'booking_total'=>$bkRate,
             'booking_city_name'=>$bkCityName,'booking_model_name'=>$bkModel,
             'booking_maker_name'=>$bkMaker,'booking_model_image'=>$bkmodelImage);
              Mail::send('front-end/mail-templates/booking-template', $data, function($message) use ($data){
                 $message->to('dipinpnambiar@gmail.com','RENT SOLUTIONS')->subject
                    ('BOOKING INFORMATION');
                //$message->from('otpmanager1993@gmail.com','RENT SOLUTIONS BOOKING INFORMATION');
            });

             
            
            return back()->with('status','Booking Status Changed');
        }else{
            return redirect('/login');
        }
    }

    public function filter(Request $request)
    {
        $pageTitle = "Booking";
        $bkDetail = Booking::orderBy('book_id','DESC')->get();
        $bkStatus = Status::orderBy('status_id','ASC')->get();
        $custmList = Customer::orderBy('customer_id','ASC')->get();
        $bookStatus = Status::orderBy('status_id','ASC')->get();
        $bookModel = Modal::orderBy('modal_id','ASC')->get();

        $refId = $request->input('reference_id');
        $frmDt = $request->input('from_date');
        $dtFrmAlt = Carbon\Carbon::parse($frmDt)->format('Y/m/d');
        $toDt  = $request->input('to_date');
        $dtToAlt = Carbon\Carbon::parse($toDt)->format('Y/m/d');
        $custId = $request->input('customers');
        $bkStatusss = $request->input('book_status');
        $modelss = $request->input('book_models');
        
         $query=Booking::select('*'); 

        if($refId){

        $query=$query->where('book_ref_id','=',$refId); 

        }
        if($custId){

        $query=$query->where('book_cust_id','=',$custId); 

        }
        if($bkStatusss){

        $query=$query->where('book_status','=',$bkStatusss); 

        }
        if($dtFrmAlt){

        $query=$query->whereDate('book_from_date','>=',$dtFrmAlt); 

        }
        if($dtToAlt){

        $query=$query->whereDate('book_to_date','<=',$dtToAlt); 

        }
        
        if($modelss){

        $query=$query->where('book_car_model','=',$modelss); 

        }

        $data['result']=$query->paginate(10);

            
            // $data['count'] = count($res);
            $data['status'] = Status::orderBy('status_id','ASC')->get();
            return view('admin.elements.booking.search',compact('pageTitle','bkDetail','bkStatus','custmList','bookStatus','bookModel','refId','frmDt','toDt','custId','bkStatusss','modelss'),$data);
      
    }
}
