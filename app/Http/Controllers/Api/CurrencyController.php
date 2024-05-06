<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Crypt;
use Auth;
use Hash;
use Carbon;
use Validator;

class CurrencyController extends Controller
{
    public function list(Request $request)
    {
    	$data = array();
    	try
    	{
	    	$data['curDet'] = Currency::orderBy('currency_id','DESC')->get();
	    	return response($data);
	    }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];
            return response($response);
        }
    	
   
    }
}
