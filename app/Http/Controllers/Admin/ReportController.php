<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Status;
use App\Models\Modal;
use App\Models\Mode_rate;
use Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check())
        {
            try
            {
            $pageTitle = "Customer Reports";
            $query = Customer::select("*");
    
            $customerNo = $request->input('cust_no');
            $customerName = $request->input('cust_name');
            $names = explode(" ", $customerName);
            $customerMobile = $request->input('cust_mobile_number');
            $profileStatus = $request->input('cust_profile_status');
    
            $OTPstatus = $request->input('cust_otp_verify');
    
            //dd($OTPstatus,$profileStatus);
    
           
            if($customerNo){
    
            $query->where('cust_code','=',$customerNo); 
    
            }
    
            if($customerName){
               /* ->Where(function ($query) use($book) {
             for ($i = 0; $i < count($book); $i++){
                $query->orwhere('bookname', 'like',  '%' . $book[$i] .'%');
             }      
        })*/
    
            $query->where(function($qry) use ($names) {
            for ($i = 0; $i < count($names); $i++)
                   {
                $qry->orwhere('cust_fname', 'like',  '%' . $names[$i] .'%');
             }     
            $qry->orWhere(function($q) use ($names) {
                for ($i = 0; $i < count($names); $i++)
                   {
                $q->orwhere('cust_lname', 'like',  '%' . $names[$i] .'%');
             }     
            });
            });
    
            }
    
            if($customerMobile){
    
            $query->where('cust_mobile_number','like','%'.$customerMobile.'%');
    
            }
           
            if($profileStatus!="")
            {
                $query->where('cust_profile_status','=',$profileStatus);
            }
                
              
            if($OTPstatus!="")
            {
                $query->where('cust_otp_verify','=',$OTPstatus);
            }
             
    
            //dd($query);
            $custDetail=$query->orderBy('customer_id','DESC')->get();
            //dd($custDetail);
            //dd(Customer::where('cust_profile_status',$profileStatus)->where('cust_otp_verify',$OTPstatus)->orderBy('customer_id','DESC')->count());
            //dd($custDetail);
        	return view('admin.elements.report.customerReport',compact('pageTitle','custDetail','customerNo','customerName','customerMobile'));
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }
        }else{
            return redirect('/login');
        }
    }
    public function booking(Request $request)
    {
        if (Auth::check())
        {
            try{
        	$pageTitle = "Booking Reports";
        	//$bkDetail = Booking::orderBy('book_id','DESC')->get();
            $bkStatus = Status::orderBy('status_id','ASC')->get();
            $custmList = Customer::orderBy('customer_id','ASC')->get();
            $bookStatus = Status::orderBy('status_id','ASC')->get();
            $bookModel = Modal::orderBy('modal_id','ASC')->get();

            $refId = $request->input('reference_id');
            $frmDt = $request->input('from_date');
            $dtFrmAlt = Carbon::parse($frmDt)->format('Y/m/d');
            $toDt  = $request->input('to_date');
            $dtToAlt = Carbon::parse($toDt)->format('Y/m/d');
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
    
            $bkDetail=$query->orderBy('book_id','DESC')->get();
        	return view('admin.elements.report.bookingReport',compact('pageTitle','bkDetail','bkStatus','custmList','bookStatus','bookModel'));
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }
        }else{
            return redirect('/login');
        }
    }
     public function modelRateReport(Request $request)
    {
        if (Auth::check())
        {
            try{
        	
           
        $pageTitle = "Model Rates Report";
        $rateDetail = Mode_rate::orderBy('model_rate_id','DESC')->get();
        $bookModel = Modal::orderBy('modal_id','ASC')->get();

       
        $modelss = $request->input('book_models');
        $fetchModel = Modal::where('modal_id','=',$modelss)->first();
        
        
        $query=Modal::select('*'); 

       
        if($modelss){

        $query=$query->where('modal_id','=',$modelss); 

        }

        $data['result']=$query->get();
        	return view('admin.elements.report.modelRateReport',compact('pageTitle','rateDetail','bookModel','fetchModel','modelss'),$data);
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }
        }else{
            return redirect('/login');
        }
    }
     public function ModalRateReportfilter(Request $request)
    {
        $pageTitle = "Model Rates";
        $rateDetail = Mode_rate::orderBy('model_rate_id','DESC')->get();
        $bookModel = Modal::orderBy('modal_id','ASC')->get();

       
        $modelss = $request->input('book_models');
        $fetchModel = Modal::where('modal_id','=',$modelss)->first();
        
        
        $query=Modal::select('*'); 

       
        if($modelss){

        $query=$query->where('modal_id','=',$modelss); 

        }

        $data['result']=$query->get();

            return view('admin.elements.model.rate.search',compact('pageTitle','rateDetail','bookModel','fetchModel','modelss'),$data);
      
    }
}
