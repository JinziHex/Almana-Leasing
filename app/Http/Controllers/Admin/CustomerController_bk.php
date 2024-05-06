<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Crypt;
use Auth;

class CustomerController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
        	$pageTitle = "Customers";
        	$custDetail = Customer::orderBy('customer_id','DESC')->get();
        	return view('admin.elements.customer.index',compact('pageTitle','custDetail'));
        }else{
            return redirect('/login');
        }
    }
    public function deactivate($id, Customer $customer)
    {
    	$decrypId = Crypt::decryptString($id);
    	Customer::where('customer_id','=',$decrypId)->update([
    		'cust_profile_status' => 0
    	]);
    	
    	return back();
    }
    public function activate($id, Customer $customer)
    {
    	$decrypId = Crypt::decryptString($id);
    	Customer::where('customer_id','=',$decrypId)->update([
    		'cust_profile_status' => 1
    	]);
    	
    	return back();
    }
    public function view($id)
    {
        if (Auth::check())
        {
        	$pageTitle = "Customer View";
        	$decrypId = Crypt::decryptString($id);
        	$viewRes = Customer::where('customer_id','=',$decrypId)->first();
        	return view('admin.elements.customer.view',compact('decrypId','viewRes','pageTitle'));
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

        $query=Customer::select('*'); 

       
        if($customerNo){

        $query=$query->where('cust_code','=',$customerNo); 

        }

        if($customerName){

           $query=$query->where(function($query) use ($names) {
        $query->whereIn('cust_fname', $names);
        $query->orWhere(function($query) use ($names) {
            $query->whereIn('cust_lname', $names);
        });
        });

        }

        if($customerMobile){

        $query=$query->where('cust_mobile_number','like','%'.$customerMobile.'%');

        }


        $data['result']=$query->paginate(10);

            return view('admin.elements.customer.search',compact('pageTitle','custDetail','customerNo','customerName','customerMobile'),$data);
      
    }
}
