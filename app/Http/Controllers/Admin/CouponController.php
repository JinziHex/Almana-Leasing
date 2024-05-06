<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Crypt;
use Illuminate\Support\Facades\Redirect;
class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       try
        {
       $coupons=Coupon::orderBy('id','DESC')->get();
       $pageTitle='Coupons';
       return view('admin.elements.coupon.index',compact('pageTitle','coupons'));
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }




    }
    public function add()
    {
        
        $pageTitle = "Add Coupon";
        return view('admin.elements.coupon.add',compact('pageTitle'));
    }
    public function save(Request $request,Coupon $coupon)
    {
        
        $validator = $request->validate([   
            'coupon_code' => 'required|unique:coupons|max:12',
            'discount_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'minimum_amount'=>'required|numeric',
            
        ],
        [ 	'coupon_code.unique' => "Coupon already taken",
            'coupon_code.max' => "Coupon code Should not Exceed Maxlength 12",
            
        ]);
        if($request->discount_type==1)
        {
            $request->validate([       
                'discount_value' => 'required|numeric|lt:minimum_amount',  
            ]);

        }
        if($request->discount_type==2)
        {
            $request->validate([       
                'discount_value' => 'required|numeric|lt:100',  
            ]);

        }

        try
        {
            $coupon->coupon_code  = $request->coupon_code;
            $coupon->coupon_description = $request->coupon_description;
            $coupon->discount_value = $request->discount_value;
            $coupon->discount_type = $request->discount_type;
            $coupon->minimum_order_amount=$request->minimum_amount;
            $coupon->start_date = $request->start_date;
            $coupon->end_date = $request->end_date;
            $coupon->save();
            // // $data= $request->except('_token');
            // $currDetail = City::firstOrCreate($data);
            return redirect('/admin/coupon')->with('status','Coupon added Successfully');
      }
    catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
	        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }
       
    }
    public function edit($id,Request $request)
    {
        try
        {
        	$coupId = Crypt::decryptString($id);
        	$pageTitle = "Edit Coupon";
        	$coupon = Coupon::findOrFail($coupId);
            return view('admin.elements.coupon.edit',compact('pageTitle','coupId','coupon'));
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }
      
    }
    public function update(Request $request, Coupon $coupon)
    {
        
        
    	$couponId = $request->coupon_id;
    	 $request->validate([   
            'coupon_code' => 'required|unique:coupons,coupon_code,'.$couponId.',id|max:12',
            'discount_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'minimum_amount'=>'required|numeric',
        ],
        [
            'coupon_code.unique' => "Coupon already taken",
            'coupon_code.max' => "Coupon code Should not Exceed Maxlength 12",
        ]);
        if($request->discount_type==1)
        {
            $request->validate([       
                'discount_value' => 'required|numeric|lt:minimum_amount',  
            ]);

        }
        if($request->discount_type==2)
        {
            $request->validate([       
                'discount_value' => 'required|numeric|lt:100',  
            ]);

        }
        try
        {

        $coupon=Coupon::findOrFail($couponId);
        $coupon->coupon_code  = $request->coupon_code;
        $coupon->coupon_description = $request->coupon_description;
        $coupon->discount_value = $request->discount_value;
        $coupon->discount_type = $request->discount_type;
        $coupon->minimum_order_amount=$request->minimum_amount;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->is_active=$request->coupon_status;
        $coupon->update();
        return redirect('/admin/coupon')->with('status','Coupon Updated');
    }
    catch (\Exception $e) 
    {
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
       
     }
     catch (\Throwable $e) {
       
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

     }
    	
    }

    public function delete($id)
    {  
        try
        {
        $decryptId = Crypt::decryptString($id);
    	$coupon=Coupon::findOrFail($decryptId);
        $coupon->delete();
        return back()->with('status','Deleted Coupon'); 
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
