<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    	$pageTitle = "All FAQ";
    	$fetchDetail = Mst_faq::orderBy('faq_id','DESC')->get();
    	return view('admin.elements.faq.list',compact('fetchDetail','pageTitle'));
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
                
        ]);
        if(!$validator->fails())
            {
            	$faqs->faq_question = $request->faq_question;
            	$faqs->faq_answer =  $request->faq_answer;
                $faqs->save();
                return redirect('admin/faqs')->with('status','Added new FAQ');
            }else{
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
    }
    
    public function editFaq($id, Request $request)
    {
        $decrId = Crypt::decryptString($id);
        $pageTitle = "Edit FAQ";
        $fetchDetail = Mst_faq::where('faq_id','=',$decrId)->first();
        return view('admin.elements.faq.edit',compact('pageTitle','fetchDetail'));
    }

    
    public function updateFaq(Request $request)
    {
        $getId = $request->faq_id;
        $mstFaqs = Mst_faq::Find($getId);
                $mstFaqs->faq_question = $request->faq_question;
                $mstFaqs->faq_answer = $request->faq_answer;
        		$mstFaqs->update();
        return redirect('admin/faqs')->with('status','Faq Updated');
    }

    
    public function deleteFaq($id, Request $request)
    {
        $decrId = Crypt::decryptString($id);
        $fetchDetail = Mst_faq::Find($decrId)->delete();
        return back()->with('status','Faq Deleted');
    }

    public function fetchBanner()
    {
        $fetchDetail = Mst_page_data::where('page_name','=','faq')->first();
        $pageTitle = "FAQ Banner";
        return view('admin.elements.faq.banner',compact('pageTitle','fetchDetail'));

    }
}
