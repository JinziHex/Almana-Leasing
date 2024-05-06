<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Modal;
use Carbon\Carbon;
use Validator;
use Crypt;
use Auth;

class PromotionController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {   
        	
            try
            {
             $pageTitle = "Promotion";
        	$proDetail = Promotion::orderBy('promotion_id','DESC')->get();
        	return view('admin.elements.promotion.index',compact('pageTitle','proDetail'));
            }
            catch (\Exception $e)
            {
         
           return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
           }
            catch (\Throwable $e)
              {
    
              return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
              }

        }else{
            return redirect('/login');
        }
    }
    public function add(Request $request)
    {
        if (Auth::check())
        { 
            try
             {
        	$pageTitle = "Add Promotion";
        	$promotion = Promotion::orderBy('modal_id','ASC')->get();

                $modal = DB::table('modals')
                    ->select(
                        'modal_name',
                        'modal_id'
                    )
                    ->whereNotExists( function ($query) use ($promotion) {
                        $query->select(DB::raw(1))
                        ->from('promotions')
                        ->whereRaw('modals.modal_id  = promotions.modal_id');
                       
                    })
                    ->get();
                return view('admin.elements.promotion.add',compact('pageTitle','modal',));
           }
        catch (\Exception $e)
        {
     
       return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

       }
        catch (\Throwable $e)
          {

          return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
          }
        }
        else
        {
            return redirect('/login');
        }
    }
    public function save(Request $request, Promotion $promotion)
    {
        // dd($request->ar_location_name);
        if (Auth::check())
        { 
        	$validator = Validator::make($request->all(), [   
                 
                'modal_id' => 'required',
                'price' => 'required|numeric|lt:100',
               
                'start_date' => 'required',
                'end_date' =>  'required|date|after_or_equal:start_date',
            ],
            [ 
                'modal_id.required' => "Modal Name is required",
                'price.required' => "Discount percentage is required",
                'price.numeric' => "Discount percentage must be a number",
                'price.lt' => "Discount percentage must be less than 100",
            	'start_date.required' => "Start Date is required",
                'end_date.required' => "End Date  is required",
                'end_date.date' => "End Date  must be greater than ore equal to start date required",

              
               
              
            ]);
            if(!$validator->fails())
            {
                try{
                $promotion->modal_id   = $request->modal_id ;
                $promotion->price = $request->price;
                $promotion->start_date = $request->start_date;
                $promotion->end_date  = $request->end_date;
             
                $promotion->save();
                return redirect('/admin/promotions')->with('status','Promotion added Successfully');
                }
                catch (\Exception $e)
                {
             
               return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
               }
                catch (\Throwable $e)
                  {
        
                  return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
                  }

             }
            else
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
        }else{
            return redirect('/login');
        }
    }
    public function delete($id)
    {
        if (Auth::check())
        {
            try{

            
        	$decryptId = Crypt::decryptString($id);
        	Promotion::where('promotion_id',$decryptId)->delete();
        	return back()->with('status','Deleted Promotion');
            }
            catch (\Exception $e)
            {
         
           return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
           }
            catch (\Throwable $e)
              {
    
              return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
              }
        }else{
            return redirect('/login');
        }
    }
    public function edit($id, Request $request)
    {
        if (Auth::check())
        {
        	try
            {
                $curId = Crypt::decryptString($id);
        	$pageTitle = "Edit Promotion";
        	$promotion = Promotion::where('promotion_id','=',$curId)->first();
        	// $modal = Modal::orderBy('modal_name','ASC')->get();
            $modal = DB::table('modals')
            ->select(
                'modal_name',
                'modal_id'
            )
            ->whereNotExists( function ($query) use ($promotion) {
                $query->select(DB::raw(1))
                ->from('promotions')
                ->whereRaw('modals.modal_id  = promotions.modal_id');
               
            })
            ->get();
        	return view('admin.elements.promotion.edit',compact('pageTitle','curId','modal','promotion'));
        }
        catch (\Exception $e)
        {
     
       return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

       }
        catch (\Throwable $e)
          {

          return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
          }

        }
        else{
            return redirect('/login');
        }
    }
    public function update(Request $request, Promotion $Promotion)
    {
        
    	$curId = $request->input('promotion_id');
        $validator = Validator::make($request->all(), [   
                 
            'modal_id' => 'required',
            'price' => 'required|numeric|lt:100',
           
            'start_date' => 'required',
            'end_date' =>  'required|date|after_or_equal:start_date',
        ],
        [ 
            'modal_id.required' => "Modal Name is required",
            'price.required' => "Discount percentage is required",
            'price.numeric' => "Discount percentage must be a number",
            'price.lt' => "Discount percentage must be less than 100",
           
            'start_date.required' => "Start Date is required",
            'end_date.required' => "End Date  is required",
            'end_date.date' => "End Date  must be greater than ore equal to start date required",

          
           
          
        ]);
    	// $validator = Validator::make($request->all(), [   
        //     'location_name' => 'unique:city_locations,location_name,'.$curId.',city_loc_id|max:150'
        // ]);
        if(!$validator->fails())
            {
            	$Promotion = Promotion::Find($curId);
            	$Promotion->modal_id   = $request->modal_id ;
                $Promotion->price = $request->price;
                $Promotion->start_date = $request->start_date;
                $Promotion->end_date  = $request->end_date;
            	$Promotion->save();
            	return redirect('/admin/promotions')->with('status','Promotion Updated');
            }
            else{
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
    	
    }
}
