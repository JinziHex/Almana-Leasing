<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Crypt;
use App\Models\Main_customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use BulkGate;
use Session;
use Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function showLoginForm()
    {
        $pageTitle = "User Login for Al Mana Leasing";
        $pageDescription = "Access your Al Mana Leasing account to manage rentals, leases, and more. Your gateway to a superior car rental experience.";
        if(!session()->has('url.intended'))
        {
        session(['url.intended' => url()->previous()]);
        }
        return view('front-end.elements.user.login',compact('pageTitle','pageDescription'));
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function username()
        {
            return 'cust_mobile';
        }

     public function usrlogin(Request $request)
    {
    //     $admin = Main_customer::where('cust_mobile',$request->cust_mobile)->first();
    //     if(Auth::guard('main_customer')->attempt($request->only('cust_mobile','password'))){
    //     //Authentication passed...
    //     return redirect()
    //         ->intended(route('app.index'))
    //         ->with('status','You are Logged in as Admin!');
    // }

        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $admin = Main_customer::where('cust_mobile',$request->cust_mobile)->first();
             if ($admin) {
                    $cId = $admin->customer_id;
                    $custFname = $admin->customer['cust_fname'];
                    $custLname = $admin->customer['cust_lname'];
                    $id = Crypt::encryptString($cId);

                if ($admin->otp_verify == 0) {
                    Auth::guard('main_customer')->logout();
                    return redirect()->action('Front\Auth\RegisterController@otpVerify', ['id' => $id]);
                }
                
                // Session::put('Log_check','1');
                // Session::put('Customer_fname',$custFname);
                // Session::put('Customer_lname',$custLname);
                Cookie::queue('Log_check', '1');
                Cookie::queue('Customer_fname', $custFname);
                Cookie::queue('Customer_lname', $custLname);
                
            }
            
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function credentials(Request $request)
    {
        $admin = Main_customer::where('cust_mobile',$request->cust_mobile)->first();
        if ($admin) {
            // $cId = $admin->customer_id;
            // $id = Crypt::encryptString($cId);

            // if ($admin->otp_verify == 0) {
            //     // return redirect()->route('user.otp.verify', ['id' => $id]);
            //     // return redirect()->action('Front\Auth\RegisterController@otpVerify', ['id' => $id]);
            //     return ['cust_mobile'=>'inactive','password'=>'You are not an active person, please contact Admin'];
            // }else{
                return ['cust_mobile'=>$request->cust_mobile,'password'=>$request->password,'profile_status'=>1];
            // }
        }
        return $request->only($this->username(), 'password');
    }
    
    //protected $redirectTo = '/';

    public function logout(Request $request)
    {
        
                // Session::put('Log_check','0');
                // Session::forget('Customer_fname');
                // Session::forget('Customer_lname');
                // Cookie::queue(Cookie::forget('Log_check'));
                // Cookie::queue(Cookie::forget('Customer_fname'));
                // Cookie::queue(Cookie::forget('Customer_lname'));
        Auth::guard('main_customer')->logout();
        // $request->session()->flush();

        // $request->session()->regenerate();
        return redirect('/');
    }
    
    public function logout2(Request $request)
    {
        
        Auth::guard('main_customer')->logout();
        // $request->session()->flush();

        // $request->session()->regenerate();
        return redirect('https://webprojects.hexeam.in/rentsolutions/');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:main_customer')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('main_customer');
    }
}
