<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Crypt;
use Illuminate\Support\Facades\Hash;
use Auth;

class StaffController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
        	$pageTitle = "Staff management";
        	$usrDetail = User::where('id','!=',1)->orderBy('id','DESC')->get();
        	return view('admin.elements.staff.index',compact('pageTitle','usrDetail'));
        }else{
            return redirect('/login');
        }
    }
    public function add(Request $request)
    {
        if (Auth::check())
        {
        	$pageTitle = "Add New Staff";
        	return view('admin.elements.staff.add',compact('pageTitle'));
        }else{
            return redirect('/login');
        }
    }

    public function save(Request $request)
    {
    	$validator = Validator::make($request->all(), [   
            'name' => 'required|unique:users',
            'staff_name' => 'required',
            'staff_code' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ],
        [ 	'name.unique' => "Username already taken",
        	'staff_name.required' => "Staff Name is required",
            'currency_name.required' =>"Currency Name is Required",
           
          
            
        ]);
        if(!$validator->fails())
        {
            User::create([
            'name' => $request->input('name'),
            'staff_name' => $request->input('staff_name'),
            'staff_code' => $request->input('staff_code'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
            return redirect('/admin/staffs')->with('status','Staff added Successfully');
        }else{
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
    }
    public function edit($id, Request $request)
    {
        if (Auth::check())
        {
        	$usrId = Crypt::decryptString($id);
        	$pageTitle = "Edit Staff";
        	$resUpdate = User::where('id','=',$usrId)->first();
        	return view('admin.elements.staff.edit',compact('pageTitle','usrId','resUpdate'));
        }else{
            return redirect('/login');
        }
    }

    public function update(Request $request, User $user)
    {
    	$upId = $request->input('user_id');
    	$name = $request->input('name');
    	$email = $request->input('email');
        $password = $request->input('password');
        if($request->has('password') && !empty($request->input('password')))
        {
            $validator = Validator::make($request->all(), [   
            'password' => ['string', 'min:8', 'confirmed'],
            
        ],
        [  
            'password.confirmed' => "confirm password does not match",
            
        ]);
            if(!$validator->fails())
        {
            User::where('id','=',$upId)->update([
                'password' => Hash::make($password)
                ]);
        }else{
           return redirect()->back()->withErrors($validator->errors())->withInput(); 
        }
        }
       
    		User::where('id','=',$upId)->update([

    			'staff_name' => $request->input('staff_name'),
    			'staff_code' => $request->input('staff_code'),
    			'mobile_number' => $request->input('mobile_number'),
    			'name' => $request->input('name'),
    			'email' => $request->input('email'),
    		]);
    		return redirect('/admin/staffs')->with('status','Staff Updated');
    		
    		
    }

    
    public function inactivate($id, User $user)
    {
        $decrypId = Crypt::decryptString($id);
        User::where('id','=',$decrypId)->update([
            'status' => 0
        ]);
        return back();
    }

    
    public function activate($id, User $user)
    {
        $decrypId = Crypt::decryptString($id);
        User::where('id','=',$decrypId)->update([
            'status' => 1
        ]);
        return back();
    }

      public function filter(Request $request)
    {
        $pageTitle = "Staff management";
        $usrDetail = User::where('id','!=',1)->orderBy('id','DESC')->get();

        $empCode = $request->input('employee_code');
        $usrName = $request->input('user_name');
        $mobileNumber = $request->input('mobile_number');

        $query=User::where('id','!=',1)->select('*'); 

        if($empCode){

        $query=$query->where('staff_code','=',$empCode); 

        }

        if($usrName){

        $query=$query->where('name','like','%'.$usrName.'%');

        }

        if($mobileNumber){

        $query=$query->where('mobile_number', $mobileNumber);

        }


        $data['result']=$query->paginate(10);

            return view('admin.elements.staff.search',compact('pageTitle','usrDetail','empCode','usrName','mobileNumber'),$data);
      
    }


}
