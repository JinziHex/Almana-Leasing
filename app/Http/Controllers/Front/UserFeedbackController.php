<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon;
use Crypt;
use Auth;
use App\Models\Feedback;
use Illuminate\Support\Facades\Validator;

class UserFeedbackController extends Controller
{
    public function feedback()
    {
    	if (Auth::guard('main_customer')->check()) {
    		$pageTitle = "Any Feedback?";
    		$subTitle = "We would love to hear from you and see how we can help. Please Complete the form below";
    		$custId = Auth::guard('main_customer')->user()->customer_id;
    		return view('front-end.elements.user.feedback',compact('pageTitle','custId','subTitle'));
    	}else{
    		return redirect('/');
    	}
    }

    public function saveFeedback(Request $request)
    {
    	if (Auth::guard('main_customer')->check()) {
    		$validator = Validator::make($request->all(), [   
                'feedback_type' => 'required',
                'feedback_message' => 'required',
                'feedback_fname' => 'required',
                'feedback_lname' => 'required',
                'feedback_email' => 'required',
                
            ],
            [ 	'feedback_type.required' => "Feedback type is required",
                'feedback_message.required' =>" Message is Required",
                'feedback_fname.required' => "First name is required",
                'feedback_lname.required' =>"Last name is required",
                'feedback_email.required' => "Email Field cannot be empty",
                
            ]);
            if(!$validator->fails())
            {
                $dataa= $request->except('_token','post_date');
                $feedDetail = Feedback::create($dataa);
                
                return redirect()->back()->with('status','Feedback Submitted');
            }else{
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
    	}else{
    		return redirect('/');
    	}
    }
}
