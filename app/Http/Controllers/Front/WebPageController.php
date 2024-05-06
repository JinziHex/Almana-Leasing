<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mst_about_us;
use App\Models\Mst_meet_our_team;
use App\Models\Mst_clients;
use App\Models\Mst_service;
use App\Models\Mst_page_data;
use App\Models\Mst_offer;
use App\Models\Mst_career;
use App\Models\Trn_career_enquiry;
use App\Models\Mst_faq;
use App\Models\Setting;
use Validator;
use Crypt;
use Auth;



class WebPageController extends Controller
{
    public function aboutPage()
    {
    	$fetchMainContent = Mst_about_us::where('about_content_id','=',1)->first();
      
    	$fetchTeam = Mst_meet_our_team::orderBy('team_id','DESC')->get();
    	$fetchClient = Mst_clients::orderBy('client_id','DESC')->get();
    	$pageTitle = "About Al Mana Leasing Company";
    	$pageDescription = "Discover the legacy of Al Mana Leasing, your trusted partner for car rental and leasing solutions in Doha.";
    	return view('front-end.website.about',compact('fetchMainContent','fetchTeam','fetchClient','pageTitle','pageDescription'));
    }

    public function servicePage()
    {
    	$pageTitle = "Our Car Rental and Leasing Services";
    	$pageDescription = "Explore a range of car leasing and rental services designed for individual and corporate clients at Al Mana Leasing.";
    	$fetchContent = Mst_service::whereNotNull('sort_order')->orderBy('sort_order','ASC')->get();
        $fetchBanner = Mst_page_data::where('page_name','=','service')->first();
    	return view('front-end.website.service',compact('fetchContent','pageTitle','pageDescription','fetchBanner'));
    }

    public function offerPage()
    {
        $fetchContent = Mst_offer::orderBy('offer_id','DESC')->get();
        $fetchBanner = Mst_page_data::where('page_name','=','offer')->first();
        return view('front-end.website.offers',compact('fetchContent','fetchBanner'));
    }

    public function careerPage()
    {
        $pageTitle = "Join Our Team at Al Mana Leasing";
    	$pageDescription = "Seeking a career in the car leasing industry? Al Mana Leasing offers exciting opportunities for growth and development.";
        $fetchContent = Mst_career::orderBy('career_id','DESC')->get();
        $fetchBanner = Mst_page_data::where('page_name','=','career')->first();
        return view('front-end.website.career.list',compact('fetchContent','fetchBanner','pageTitle','pageDescription'));
    }

    
    public function quickEnquirySave(Request $request, Trn_career_enquiry $career_enquiry)
    {
        $validator = Validator::make($request->all(), [   
                'enquiry_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'enquiry_email' => 'required|email',
                'enquiry_phone' => 'required|integer',
                'enquiry_location' => 'required',
                'enquiry_cv' => 'required|mimes:pdf,doc,docx',
                'enquiry_message' => 'required',
                'g-recaptcha-response'=>'required',
        ],
        [
            'g-recaptcha-response.required' => 'Please complete the captcha'
        ]
        );
        
        if(!$validator->fails())
            {
                $res=$request->input('g-recaptcha-response');
                $data = array('secret' => env('GOOGLE_RECAPTCHA_SECRET'),'response'=>$res);
                 $verify = curl_init();
                curl_setopt($verify, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
                curl_setopt($verify, CURLOPT_POST, true);
                curl_setopt($verify, CURLOPT_POSTFIELDS,
                http_build_query($data));
                curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($verify);
                $decoded_response = json_decode($response, true);
                
                $career_enquiry->enquiry_name = $request->enquiry_name;
                $career_enquiry->enquiry_email =  $request->enquiry_email;
                $career_enquiry->enquiry_phone = $request->enquiry_phone;
                $career_enquiry->enquiry_location =$request->enquiry_location;
                $career_enquiry->enquiry_message =  $request->enquiry_message;
                if ($request->career_id) {
                    $career_enquiry->career_id = $request->career_id;
                }
               

                if ($request->hasFile('enquiry_cv'))
                    {
                        $docFile = $career_enquiry->enquiry_name.'_'.time().'.'.$request->enquiry_cv->extension();  
                        $request->enquiry_cv->move('assets/uploads/career/cv', $docFile);
                        $career_enquiry->enquiry_cv = $docFile;
                        
                    }
              
                $career_enquiry->save();

                //send mail to the rentsolutions admin 

                return redirect()->back()->with('status','Thank you for your message.Enquiry Submitted Successfully.');
            }else{
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
    }

    
    public function careerDetail(Request $request, $id)
    {
        $fetchBanner = Mst_page_data::where('page_name','=','career')->first();
        $fetchCareer = Mst_career::where('career_title_slug','=',$id)->first();
        return view('front-end.website.career.detail',compact('fetchCareer','fetchBanner'));
    }

    public function listFaqs()
    {
        $fetchBanner = Mst_page_data::where('page_name','=','faq')->first();
        $fetchfaqs = Mst_faq::orderBy('faq_id','DESC')->get();
        return view('front-end.website.faq',compact('fetchBanner','fetchfaqs'));
    }

    
    public function listTerms()
    {
        $pageTitle = "Terms and Conditions of Service";
    	$pageDescription = "Understand the terms of service for car leasing and rental with Al Mana Leasing. We value transparency and trust.";
          $fetchBanner = Mst_page_data::where('page_name','=','terms-and-conditions')->first();
        //   $fetchBanner =Setting::where('id','=','1')->first();
        return view('front-end.website.terms-and-conditions',compact('fetchBanner','pageTitle','pageDescription'));
    }
 
    public function listPackage()
    {
        $pageTitle = "Rental Processes and Packages";
    	$pageDescription = "Simplify your car rental with Al Mana Leasing's streamlined processes and customizable packages. Rent with confidence today.";
        $fetchBanner = Mst_page_data::where('page_name','=','process-and-package')->first();
        return view('front-end.website.process-and-package',compact('fetchBanner','pageTitle','pageDescription'));
    }
    
    public function listRequirements()
    {
        $pageTitle = "Rental Requirements at Al Mana Leasing";
        $pageDescription = "Learn about the necessary criteria to lease or rent vehicles at Al Mana Leasing, ensuring a seamless experience.";
        $fetchBanner = Mst_page_data::where('page_name','=','requirements')->first();
        return view('front-end.website.requirements',compact('fetchBanner','pageTitle','pageDescription'));
    }

    
    public function listCarfSale()
    {
        $pageTitle = "Quality Pre-Owned Cars for Sale in Doha";
        $pageDescription = "Find the perfect pre-owned vehicle with Al Mana Leasing's wide selection of quality cars. Drive your dream car home today.";
        $fetchBanner = Mst_page_data::where('page_name','=','car-for-sale')->first();
        return view('front-end.website.car-for-sale',compact('fetchBanner','pageTitle','pageDescription'));
    }
    
    public function limousineAndChaufeerServices()
    {
        $pageTitle = "Limousine & Chauffeur Services";
        $pageDescription = "Travel in luxury with Al Mana Leasing's limousine and chauffeur services. Premium comfort and style for any occasion.";
        $fetchBanner = Mst_service::where('service_slug','=','limousine-service')->first();
        return view('front-end.website.limousine-service',compact('fetchBanner','pageTitle','pageDescription'));
    }
    
    public function serviceAndMaintenance()
    {
        $fetchBanner = Mst_service::where('service_slug','=','service-and-maintenance')->first();
        return view('front-end.website.service-and-maintenance',compact('fetchBanner'));
    }

    
    public function listLongTerm()
    {
        $pageTitle = "Long-Term Car Leases";
        $pageDescription = "Consider a long-term car lease with Al Mana Leasing for cost-effective, reliable transportation solutions in Doha.";
        $fetchBanner = Mst_page_data::where('page_name','=','long-term-car-rental')->first();
        return view('front-end.website.long-term-rental',compact('fetchBanner','pageTitle','pageDescription'));
    }
    public function listShortTerm()
    {
        $pageTitle = "Short-Term Car Rentals in Doha";
        $pageDescription = "Need a car for a day, a week, or a month? Al Mana Leasing offers flexible short-term rental options to fit your schedule.";
        $fetchBanner = Mst_page_data::where('page_name','=','short-term-car-rental')->first();
        return view('front-end.website.short-term-rental',compact('fetchBanner','pageTitle','pageDescription'));
    }

    
    public function listLeaseToOwn()
    {
        $pageTitle = "Lease-to-Own Car Options";
        $pageDescription = "Explore Al Mana Leasing's lease-to-own programs. Drive the car you love with an option to own it down the line.";
        $fetchBanner = Mst_page_data::where('page_name','=','lease-to-own')->first();
        return view('front-end.website.lease-to-own',compact('fetchBanner','pageTitle','pageDescription'));
    }

    
    public function fetchService($id)
    {
        $fetchService = Mst_service::where('service_slug','=',$id)->first();
        $fetchBanner = Mst_page_data::where('page_name','=','service')->first();
        return view('front-end.website.service-single',compact('fetchService','fetchBanner'));
    }










}
