<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon;
use Crypt;
use Auth;
use App\Models\Feedback;
use App\Models\Api\Notification;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function getNotifications()
    {
		if (Auth::guard('main_customer')->check()) {
    		$pageTitle = "Notifications";
    		$subTitle = "We would love to hear from you and see how we can help. Please Complete the form below";
    		$fetchNot = Notification::where('customer_id','=',Auth::guard('main_customer')->user()->customer_id)->orderBy('notification_id','DESC')->get();
    		
    		return view('front-end.elements.user.notification',compact('pageTitle','subTitle','fetchNot'));
    	}else{
    		return redirect('/');
    	}
    }
}
