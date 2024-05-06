<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Crypt;
use Illuminate\Support\Facades\Hash;
use Auth;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check())
        {
            try
            {
        	$pageTitle = "Staff management";
        	$usrDetail = User::where('id','!=',1)->orderBy('id','DESC')->get();
        

              // filter
              if ($_GET) {
            
               
                $empCode = $request->input('employee_code');
                $usrName = $request->input('user_name');
                $mobileNumber = $request->input('mobile_number');
                $Status = $request->input('status');

                
			$query = User::where('id','!=',1)->select('users.*');
       
           
            
            if (isset($empCode)) {
				$query = $query->where('users.staff_code', $empCode);
			}
            if (isset($usrName)) {
				$query = $query->where('users.name', $usrName);
			}
          
            if (isset($mobileNumber)) {
				$query = $query->where('users.mobile_number', $mobileNumber);
			}
       

            if (isset($Status)) {
                $query = $query->where('users.status', $Status);
              }
      
          
    
         $usrDetail =  $query->paginate(20);

          
            
         return view('admin.elements.staff.index',compact('pageTitle','usrDetail'));
            }
            return view('admin.elements.staff.index',compact('pageTitle','usrDetail'));
        }
    
    catch (\Exception $e)
    {
            
    return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
   
    }catch (\Throwable $e) 
    {
    
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

    }
} 
        else{
            return redirect('/login');
        }
    }
    public function add(Request $request)
    {
        if (Auth::check())
        {
        	try{
            $pageTitle = "Add New Staff";
        	return view('admin.elements.staff.add',compact('pageTitle'));
            }
            catch (\Exception $e)
            {
                    
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
            }catch (\Throwable $e) 
            {
            
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
            }

        }else{
            return redirect('/login');
        }
    }

    public function save(Request $request)
    {
        $staffId=$request->staff_id;
    	$validator = Validator::make($request->all(), [   
            'name' => 'required|unique:users,name,'.$staffId.',id',
            'mobile_number'=>'required|digits:8',
            'staff_name' => 'required',
            'staff_code' => 'required|unique:users,staff_code,'.$staffId.',id',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ],
        [ 	'name.unique' => "Username already taken",
        	'staff_name.required' => "Staff Name is required",
            'currency_name.required' =>"Currency Name is Required",
           
          
            
        ]);
        if(!$validator->fails())
        {
            try
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
         }
         catch (\Exception $e)
         {
                 
         return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
         }catch (\Throwable $e) 
         {
         
             return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
     
         }

        }

        else{
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
    }
    public function edit($id, Request $request)
    {
        if (Auth::check())
        {
        	
            try
            {
                $usrId = Crypt::decryptString($id);
        	$pageTitle = "Edit Staff";
        	$resUpdate = User::where('id','=',$usrId)->first();
        	return view('admin.elements.staff.edit',compact('pageTitle','usrId','resUpdate'));
            }
            catch (\Exception $e)
            {
                    
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
            }catch (\Throwable $e) 
            {
            
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
            }

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
        $validator = Validator::make($request->all(), [   
            'name' => 'required|unique:users,name,'.$upId.',id',
            'staff_name' => 'required',
            'mobile_number'=>'required|digits:8',
            'staff_code' => 'required|unique:users,staff_code,'.$upId.',id',
            
        ],
        [ 	'name.unique' => "Username already taken",
        	'staff_name.required' => "Staff Name is required",
            'staff_code.unique' => "Staff code already taken",
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors())->withInput(); 
        }
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
        }
        else
        {
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
        try
        {
            $decrypId = Crypt::decryptString($id);
        User::where('id','=',$decrypId)->update([
            'status' => 0
        ]);
    }
    catch (\Exception $e) {
                
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
       
     }catch (\Throwable $e) {
       
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

     }

        return back();
    }

    
    public function activate($id, User $user)
    {
        try{
        $decrypId = Crypt::decryptString($id);
        User::where('id','=',$decrypId)->update([
            'status' => 1
        ]);
      }
      catch (\Exception $e) {
                
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
       
     }catch (\Throwable $e) {
       
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

     }
    

        return back();
    }

      public function filter(Request $request)
    {
        try{
        $pageTitle = "Staff management";
        $usrDetail = User::where('id','!=',1)->orderBy('id','DESC')->get();

        $empCode = $request->input('employee_code');
        $usrName = $request->input('user_name');
        $mobileNumber = $request->input('mobile_number');
        $Status = $request->input('status');
       

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
       
       if($Status!=""){
            $query = $query->where('users.status', $Status);
          }

        $data['result']=$query->paginate(10);

            return view('admin.elements.staff.search',compact('pageTitle','usrDetail','empCode','usrName','mobileNumber'),$data);
        }
        catch (\Exception $e) {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }

    }
    public function delete($id)
    {   
        try
        {
            $decryptId = Crypt::decryptString($id);
    	$staff=User::findOrFail($decryptId);
        $staff->delete();
        return back()->with('status','Deleted staff'); 
        }
        catch (\Exception $e) {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }

    }


}
