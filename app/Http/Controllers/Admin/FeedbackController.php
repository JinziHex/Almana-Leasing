<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Customer;
use Auth;
use Carbon;
use App\Helpers\Helper;
use Crypt;

class FeedbackController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {   
            try{
                $pageTitle = "Customer Feedbacks";
                $feedDetail = Feedback::orderBy('feedback_id','DESC')->get();
                $custDetail = Customer::orderBy('customer_id','DESC')->get();
                return view('admin.elements.feedback.index',compact('pageTitle','feedDetail','custDetail'));
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

    public function view($id)
    {
        if (Auth::check())
        {
            try{
                $pageTitle = "View Feedback";
                $fedId = Helper::decryptSting($id);
                $feedDetail = Feedback::where('feedback_id',$fedId)->first();
                return view('admin.elements.feedback.view',compact('pageTitle','fedId','feedDetail'));

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

    public function filter(Request $request)
    {
        try{
        $pageTitle = "Customer Feedbacks";
        //$feedDetail = Feedback::orderBy('feedback_id','DESC')->get();
        $custDetail = Customer::orderBy('customer_id','DESC')->get();
       

       
        $frmDt = $request->input('from_date');
        $dtFrmAlt = Carbon\Carbon::parse($frmDt)->format('Y/m/d');
        $toDt  = $request->input('to_date');
        $dtToAlt = Carbon\Carbon::parse($toDt)->format('Y/m/d');
        $type = $request->input('complaint_type');
        $customr = $request->input('book_customers');
        $ar[] = $dtFrmAlt;
        $ar[] = $dtToAlt;
        
         $query=Feedback::select('*'); 

       
       
        if($ar){

        $query->whereBetween('created_at',$ar); 

        }
       
        
        if($customr!=""){

        $query->where('customer_id','=',$customr); 

        }
        if($type!=""){

        $query->where('feedback_type','=',$type); 

        }


        //$data['result']=$query->paginate(10);
        $feedDetail = $query->orderBy('feedback_id','DESC')->get();

            
        return view('admin.elements.feedback.search',compact('pageTitle','feedDetail','custDetail','frmDt','toDt','type','customr'));
    }
    catch (\Exception $e) 
    {
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
       
     }
     catch (\Throwable $e) {
       
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

     }
      
    }
}
