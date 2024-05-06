<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mode_rate;
use App\Models\Rate_type;
use App\Models\Modal;
use Auth;
use App\Helpers\Helper;
use Crypt;

class ModelRateController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check())
        {   
        	$pageTitle = "Model Rates";
        	
        	$bookModelsam = Modal::orderBy('modal_id','ASC')->get();
            $rate = Rate_type::orderBy('rate_type_id','ASC')->get();
            $bookModel = Modal::orderBy('modal_id','ASC')->get();
            $modalRate=Mode_rate::where('model_rate_id','!=',NULL)->get();
            
             // filter
             if ($_GET) {
                $modelss = $request->book_models;
                $rateType = $request->rate_type;
               

                
			$query = Mode_rate::where('model_rate_id','!=',NULL)->select('mode_rates.*')
            ->leftjoin('modals', 'modals.model_number', '=', 'mode_rates.model_id')
            
            ->leftjoin('rate_types', 'rate_types.rate_type_id', '=', 'mode_rates.rate_type_id');
       
           
            
            if (isset($modelss)) {
				$query = $query->where('modals.modal_id', $modelss);
			}
            if (isset($rateType)) {
				$query = $query->where('rate_types.rate_type_id', $rateType);
			}
          
              $modalRate =  $query->paginate(20);

          
            
              return view('admin.elements.model.rate.index',compact('pageTitle','rate','modalRate','bookModel','bookModelsam'));
            }
             


           return view('admin.elements.model.rate.index',compact('pageTitle','modalRate','rate','bookModel','bookModelsam'));
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
        $rateType = $request->input('rate_type');
        
        $fetchModel = Modal::where('modal_id','=',$modelss)->first();
        $fetchModel = Mode_rate::where('rate_type_id','=',$rateType)->first();
        
        
        $query=Modal::select('*'); 
        $query=Mode_rate::select('*'); 

       
        if($modelss){

        $query=$query->where('modal_id','=',$modelss); 

        }
        if($rateType){

            $query=$query->where('rate_type_id','=',$rateType); 
    
            }

        $data['result']=$query->get();

            return view('admin.elements.model.rate.search',compact('pageTitle','rateDetail','bookModel','fetchModel','modelss'),$data);
      
    }
}
