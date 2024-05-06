<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Validator;
use Crypt;
use Auth;

class CurrencyController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {   
        	$pageTitle = "Currency";
        	$curDetail = Currency::orderBy('currency_id','ASC')->get();
        	return view('admin.elements.currency.index',compact('pageTitle','curDetail'));
        }else{
            return redirect('/login');
        }
    }

    public function add(Request $request)
    {
        if (Auth::check())
        { 
        	$pageTitle = "Add Currency";
        	return view('admin.elements.currency.add',compact('pageTitle'));
        }else{
            return redirect('/login');
        }
    }

    public function save(Request $request)
    {
        if (Auth::check())
        { 
        	$validator = Validator::make($request->all(), [   
                'currency_code' => 'required|unique:currencies',
                'currency_name' => 'required',
                'currency_conversion_rate' => 'required',
                
            ],
            [ 	'currency_code.unique' => "Currency code already taken",
            	'currency_code.required' => "Currency code is required",
                'currency_name.required' =>"Currency Name is Required",
                'currency_conversion_rate.required' => "Conversion rate is required"
                
            ]);
            if(!$validator->fails())
            {
                $data= $request->except('_token');
                $currDetail = Currency::create($data);
                return redirect('/admin/currency')->with('status','Currency added Successfully');
            }else{
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
        }else{
            return redirect('/login');
        }
    }

    public function edit($id, Request $request)
    {
        if (Auth::check())
        {
        	$curId = Crypt::decryptString($id);
        	$pageTitle = "Edit Currency";
        	$resUpdate = Currency::where('currency_id','=',$curId)->first();
        	return view('admin.elements.currency.edit',compact('pageTitle','curId','resUpdate'));
        }else{
            return redirect('/login');
        }
    }

    public function update(Request $request, Currency $currency)
    {
    	$curId = $request->input('currency_id');
    	$currency = Currency::Find($curId);
    	$currency->currency_code = $request->input('currency_code');
    	$currency->currency_name = $request->input('currency_name');
    	$currency->currency_conversion_rate = $request->input('currency_conversion_rate');
    	$currency->save();
    	return redirect('/admin/currency')->with('status','Currency Updated');
    }

    public function delete($id)
    {
        if (Auth::check())
        {
        	$decryptId = Crypt::decryptString($id);
        	Currency::where('currency_id',$decryptId)->delete();
        	return back()->with('status','Deleted Currency');
        }else{
            return redirect('/login');
        }
    }
}
