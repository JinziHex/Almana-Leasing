<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mode_rate;
use App\Models\Modal;
use Auth;
use App\Helpers\Helper;
use Crypt;

class ModelRateController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {   
        	$pageTitle = "Model Rates";
        	
        	$bookModelsam = Modal::orderBy('modal_id','ASC')->get();
        
            $bookModel = Modal::orderBy('modal_id','ASC')->get();
        	return view('admin.elements.model.rate.index',compact('pageTitle','bookModel','bookModelsam'));
        }else{
            return redirect('/login');
        }
    }

    
    public function filter(Request $request)
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
