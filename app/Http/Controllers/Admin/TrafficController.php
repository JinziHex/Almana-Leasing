<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Traffic_Violation;
use App\Models\Modal;
use App\Helpers\Helper;
use Auth;
use Carbon;
use Crypt;


class TrafficController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {   
            try
            {
        	$pageTitle = "Traffic Violations";
        	$trafDetail = Traffic_Violation::orderBy('violation_id','DESC')->get();
            $bookModel = Modal::orderBy('modal_id','DESC')->get();
        	return view('admin.elements.traffic.index',compact('pageTitle','trafDetail','bookModel'));
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
            try
            {
            $pageTitle = "View Violation Detail";
            $trId = Helper::decryptSting($id);
            $traffDetail = Traffic_Violation::where('violation_id',$trId)->first();
            return view('admin.elements.traffic.view',compact('pageTitle','trId','traffDetail'));
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
        try
        {
        $pageTitle = "Traffic Violations";
        $trafDetail = Traffic_Violation::orderBy('violation_id','DESC')->get();
        $bookModel = Modal::orderBy('modal_id','DESC')->get();

       
        $frmDt = $request->input('from_date');
        $dtFrmAlt = Carbon\Carbon::parse($frmDt)->format('Y/m/d');
        $toDt  = $request->input('to_date');
        $dtToAlt = Carbon\Carbon::parse($toDt)->format('Y/m/d');
        $regNo = $request->input('reg_number');
        $modelss = $request->input('book_models');
        $ar[] = $dtFrmAlt;
        $ar[] = $dtToAlt;
        
         $query=Traffic_Violation::select('*'); 

       
       
        if($ar){

        $query=$query->whereBetween('created_at',$ar); 

        }
       
        
        if($modelss){

        $query=$query->where('model_id','=',$modelss); 

        }
        if($regNo){

        $query=$query->where('model_reg_no','=',$regNo); 

        }


        $data['result']=$query->paginate(10);

            
        return view('admin.elements.traffic.search',compact('pageTitle','trafDetail','bookModel','frmDt','toDt','regNo','modelss'),$data);
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
