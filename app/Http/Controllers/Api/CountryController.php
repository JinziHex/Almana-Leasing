<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Crypt;
use Auth;
use Hash;
use Carbon;
use Validator;

class CountryController extends Controller
{
    public function listCountry(Request $request)
    {
    	$data = array();
    	try
    	{
	    	$data['Countries'] = Country::select('country_id','country_name','phonecode','iso3')->orderBy('country_id','ASC')->get();
	    	
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
