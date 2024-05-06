<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\CustomerCoupon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Model_specification;
use Crypt;
use Auth;

class CustomerController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
            try
            {
        	$pageTitle = "Customers";
        	$custDetail = Customer::orderBy('customer_id','DESC')->get();
        	return view('admin.elements.customer.index',compact('pageTitle','custDetail'));
            }
            catch (\Exception $e) {
                
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
               
             }catch (\Throwable $e) {
               
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
             }

        }else{
            return redirect('/login');
        }
    }
    public function deactivate($id, Customer $customer)
    {
        try
        {
    	$decrypId = Crypt::decryptString($id);
    	Customer::where('customer_id','=',$decrypId)->update([
    		'cust_profile_status' => 0
    	]);
        }
       catch (\Exception $e) {
                
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
       
        }catch (\Throwable $e) {
        
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

        }

    	return back();
    }
    public function activate($id, Customer $customer)
    {
        try
        {
    	$decrypId = Crypt::decryptString($id);
    	Customer::where('customer_id','=',$decrypId)->update([
    		'cust_profile_status' => 1
    	]);
       }
       catch (\Exception $e)
        {
                
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
       
        }catch (\Throwable $e) 
        {
        
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

        }

    	
    	return back();
    }
    public function view($id)
    {
        if (Auth::check())
        {
            try
            {
        	$pageTitle = "Customer View";
        	$decrypId = Crypt::decryptString($id);
        	$viewRes = Customer::where('customer_id','=',$decrypId)->first();
         
        	return view('admin.elements.customer.view',compact('decrypId','viewRes','pageTitle'));
            }
            catch (\Exception $e) {
                
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
               
             }catch (\Throwable $e) {
               
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
             }

        }else{
            return redirect('/login');
        }
    }

    public function delete($id)
    {
        $decryptId = Crypt::decryptString($id);
        Customer::where('customer_id','=',$decrypId)->delete();
        return back()->with('status','Deleted Customer');
    }

    public function filter(Request $request)
    {
        $pageTitle = "Customers";
        $custDetail = Customer::orderBy('customer_id','DESC')->get();

        $customerNo = $request->input('cust_no');
        $customerName = $request->input('cust_name');
        $names = explode(" ", $customerName);
        $customerMobile = $request->input('cust_mobile_number');
        $profileStatus = $request->input('cust_profile_status');
        $OTPstatus = $request->input('cust_otp_verify');

        $query=Customer::select('*'); 

       
        if($customerNo){

        $query=$query->where('cust_code','=',$customerNo); 

        }

        if($customerName){

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

        $query=$query->where('cust_mobile_number','like','%'.$customerMobile.'%');

        }
        if($profileStatus!=""){
            $query = $query->where('customers.cust_profile_status', $profileStatus);
          }
          if($OTPstatus!=""){
            $query = $query->where('customers.cust_otp_verify', $OTPstatus);
          }


        $data['result']=$query->paginate(10);

            return view('admin.elements.customer.search',compact('pageTitle','custDetail','customerNo','customerName','customerMobile'),$data);
      
    }
    public function assignCoupon($id)
    {
        if (Auth::check())
        {
        	$pageTitle = "Assign Coupon to customer";
        	$decrypId = Crypt::decryptString($id);
        	$customer = Customer::where('customer_id','=',$decrypId)->first();
            $customer_coupons=CustomerCoupon::With('coupon')->where('customer_id',$decrypId)->get();
            $customer_coupon_ids=CustomerCoupon::With('coupon')->where('customer_id',$decrypId)->pluck('coupon_id')->all();
            //dd($customer_coupon_ids);
            $coupons=Coupon::WhereNotIn('id',$customer_coupon_ids)->where('is_active',1)->where('end_date','>=',date('Y-m-d'))->get();
        	return view('admin.elements.customer.assign_coupon',compact('customer','pageTitle','coupons','customer_coupons'));
        }else{
            return redirect('/login');
        }

    }
    public function assignCouponStore(Request $request)
    {
        $cust_coupon=new CustomerCoupon();
        $cust_coupon->customer_id=$request->customer_id;
        $cust_coupon->coupon_id=$request->coupon;
        $cust_coupon->save();
        return back()->with('status','Assigned coupon!');

    }
    public function deleteAssignedCoupon(Request $request,$id)
    {
        $decryptId = Crypt::decryptString($id);
        CustomerCoupon::where('id','=',$decryptId)->delete();
        return back()->with('status','Deleted assigned coupon');
        
    }
}
