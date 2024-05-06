<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon;
use Crypt;
use Auth;
use App\Models\Feedback;
use Illuminate\Support\Facades\Validator;

class UserTrafficController extends Controller
{
    public function getTrafiicViolation()
    {
		if (Auth::guard('main_customer')->check()) {
    		$pageTitle = "TRAFFIC VIOLATION INQUIRY";
    		$subTitle = "To check MOI traffic violation,Please click the button below";
    		return view('front-end.elements.user.traffic-violation',compact('pageTitle','subTitle'));
    	}else{
    		return redirect('/');
    	}
    }
}
