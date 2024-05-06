<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Crypt;
use Auth;
use Hash;
use Carbon;
use Validator;

class FeedbackController extends Controller
{
    public function save(Request $request)
    {
    	$data = array();
    	try
    	{	
    		//get customer id through as input 
    		//feedback type 1 = complaint and 2 equals suggestion

    		
	    	$validator = Validator::make($request->all(), [   
                'feedback_type' => 'required',
                'feedback_message' => 'required',
                'feedback_fname' => 'required',
                'feedback_lname' => 'required'
                
            ],
            [ 	'feedback_type.required' => "Feedback type is required",
                'feedback_message.required' =>" Message is Required",
                'feedback_fname.required' => "First name is required",
                'feedback_lname.required' =>"Last name is required"
                
            ]);
            if(!$validator->fails())
            {
                $dataa= $request->except('_token','post_date');
                $feedDetail = Feedback::create($dataa);
                
                $data['status'] = 1;
                $data['message'] = "Feedback Added Successfully";
            }else{
                $data['errors'] = $validator->errors();
                $data['message'] = "Feedback Upload Failed";
            }

	    }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];
            return response($response);
        }
        return response($data);
    	
   
    }
}
