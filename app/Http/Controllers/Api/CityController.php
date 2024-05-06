<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Crypt;
use Auth;
use Hash;
use Carbon;
use Validator;

class CityController extends Controller
{
    public function show(Request $request)
    {
    	$data = array();
    	try
    	{
    		$data['cityDet'] = City::orderBy('city_id','DESC')->get();
    		return response($data)->setStatusCode(200);
    	}catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];

            return response($response);
        }
    	
    }
    
    public function webCityList(Request $request)
    {
    	$data = array();
    	try
    	{
    		$data['cityDet'] = City::orderBy('city_id','DESC')->get();
    		return response($data)->setStatusCode(200);
    	}catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];

            return response($response);
        }
    	
    }
}
