<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Mst_faq;
use App\Models\Mst_page_data;
use Validator;
use Crypt;
use Auth;
use Image;

class FaqController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function listFaqs()
    {
        try
        {
    	$pageTitle = "All FAQ";
    	$fetchDetail = Mst_faq::orderBy('faq_id','DESC')->get();
    	return view('admin.elements.faq.list',compact('fetchDetail','pageTitle'));
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }
    }
    
    public function addFaq()
    {
    	$pageTitle = "Add New FAQ";
    	return view('admin.elements.faq.add',compact('pageTitle'));
    }

    
    public function saveFaq(Request $request, Mst_faq $faqs)
    {
    	$validator = Validator::make($request->all(), [   
                'faq_question' => 'required',
                'faq_answer' => 'required',
                'arabic_faq_question' => 'required',
                'arabic_faq_answer' => 'required',
                
        ]);
        if(!$validator->fails())
            {
                try
                {
            	$faqs->faq_question = $request->faq_question;
                $faqs->ar_faq_question = $request->ar_faq_question;
            	$faqs->faq_answer =  $request->faq_answer;
                $faqs->ar_faq_question = $request->arabic_faq_question;
            	$faqs->ar_faq_answer =  $request->arabic_faq_answer;
                $faqs->save();
                $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
                $far=json_decode($lang_file_ar,true);
                $data_ar = [
                    $faqs->faq_question  => $faqs->ar_faq_question,
                    $faqs->faq_answer  => $faqs->ar_faq_answer

                ];
                $data_en = [
                    $faqs->faq_question  => $faqs->faq_question,
                    $faqs->faq_answer  => $faqs->faq_answer

                ];
                $result_ar = array_merge($far,$data_ar);
                file_put_contents(resource_path('lang/'.'ar'.'.json'),json_encode($result_ar,JSON_PRETTY_PRINT));
                 return redirect('admin/faqs')->with('status','Added new FAQ');
              }
            catch (\Exception $e) 
            {
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
               
             }
             catch (\Throwable $e) {
               
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
             }
            }else{
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
    }
    
    public function editFaq($id, Request $request)
    {
        try{
        $decrId = Crypt::decryptString($id);
        $pageTitle = "Edit FAQ";
        $fetchDetail = Mst_faq::where('faq_id','=',$decrId)->first();
        return view('admin.elements.faq.edit',compact('pageTitle','fetchDetail'));
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }
    }

    
    public function updateFaq(Request $request)
    {
        try{
        $getId = $request->faq_id;
        $mstFaqs = Mst_faq::Find($getId);
                $mstFaqs->faq_question = $request->faq_question;
                $mstFaqs->ar_faq_question = $request->ar_faq_question;
                
                $mstFaqs->faq_answer = $request->faq_answer;
                $mstFaqs->ar_faq_question = $request->arabic_faq_question;
            	$mstFaqs->ar_faq_answer =  $request->arabic_faq_answer;
        		$mstFaqs->update();
                $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
                $far=json_decode($lang_file_ar,true);
                $data_ar = [
                    $mstFaqs->faq_question  => $mstFaqs->ar_faq_question,
                    $mstFaqs->faq_answer => $mstFaqs->ar_faq_answer 
                
                ];
                $result_ar = array_merge($far,$data_ar);
                file_put_contents(resource_path('lang/'.'ar'.'.json'),json_encode($result_ar,JSON_PRETTY_PRINT));
        return redirect('admin/faqs')->with('status','Faq Updated');
            }
            catch (\Exception $e) 
            {
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
               
             }
             catch (\Throwable $e) {
               
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
             }
    }

    
    public function deleteFaq($id, Request $request)
    {
        try{
        $decrId = Crypt::decryptString($id);
        $fetchDetail = Mst_faq::Find($decrId)->delete();
        return back()->with('status','Faq Deleted');
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }
    }

    public function fetchBanner()
    {
        try
        {
        $pageTitle = "FAQ Banner";
        $fetchDetail = Mst_page_data::where('page_name','=','faq')->first();
       
        return view('admin.elements.faq.banner',compact('pageTitle','fetchDetail'));
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }

    }
}
