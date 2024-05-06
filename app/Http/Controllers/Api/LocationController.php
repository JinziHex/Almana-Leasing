<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City_location;
use Crypt;
use Auth;
use Hash;
use Carbon;
use Validator;

class LocationController extends Controller
{
    public function show(Request $request)
    {
    	$data = array();
    	try
    	{
	    	$data['locDet'] = City_location::orderBy('city_loc_id','DESC')->get();
	    	return response($data)->setStatusCode(200);
	    }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];
            return response($response);
        }
    }
    
    
    
    public function webLocationList(Request $request)
    {
    	$data = array();
    	try
    	{
	    	$data['locDet'] = City_location::orderBy('city_loc_id','DESC')->get();
	    	return response($data)->setStatusCode(200);
	    }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];
            return response($response);
        }
    }

    public function getLocation(Request $request)
    {
        $data = array();
        $model = array();
        try{
            $sid        =   $request->city_id;
            $location = City_location::where("city_id",'=',$sid)->get();
          $loc = array();
        //   if (!$location->isEmpty()) {
        //     $data['status'] = 1;
              foreach ($location as $locations) {
                $loc['locationId'] = $locations->city_loc_id;
                $loc['locationName'] = $locations->location_name;
                $loc['locationName_Arb'] = $locations->ar_location_name;
                array_push($model,$loc);
                }
        //   }else{
        //     $data['status'] = 0;
        //     $data['message'] = "No Locations Found";
        //   }
           
            // $data['Locations'] = $model;
            return response($model);
        // $sid        =   $request->city_id;
        //     $location = City_location::where("city_id",'=',$sid)->get();
        //   $loc = array();
        //   if (!$location->isEmpty()) {
        //       $model['status'] = 1;
        //     foreach ($location as $locations) {
        //         $loc['locationId'] = strval($locations->city_loc_id);
        //         $loc['locationName'] = $locations->location_name;
        //         array_push($model,$loc);
        //     }
        //   }else{
        //     $model['status'] = 0;
        //     $model['message'] = "No Locations Found";
        //   }
            // $data['Locations'] = $model;
            // return response($model);
        }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];
            return response($response);
        }
    }
    
    
    public function getLocationBasedOnCityWEb(Request $request)
    {
        $data = array();
        $model = array();
        try{
            $sid        =   $request->city_id;
            $location = City_location::where("city_id",'=',$sid)->get();
          $loc = array();
        //   if (!$location->isEmpty()) {
        //     $data['status'] = 1;
              foreach ($location as $locations) {
                $loc['locationId'] = $locations->city_loc_id;
                $loc['locationName'] = $locations->location_name;
                $loc['locationName_Arb'] = $locations->ar_location_name;
                array_push($model,$loc);
                }
        //   }else{
        //     $data['status'] = 0;
        //     $data['message'] = "No Locations Found";
        //   }
           
            // $data['Locations'] = $model;
            return response($model);
        // $sid        =   $request->city_id;
        //     $location = City_location::where("city_id",'=',$sid)->get();
        //   $loc = array();
        //   if (!$location->isEmpty()) {
        //       $model['status'] = 1;
        //     foreach ($location as $locations) {
        //         $loc['locationId'] = strval($locations->city_loc_id);
        //         $loc['locationName'] = $locations->location_name;
        //         array_push($model,$loc);
        //     }
        //   }else{
        //     $model['status'] = 0;
        //     $model['message'] = "No Locations Found";
        //   }
            // $data['Locations'] = $model;
            // return response($model);
        }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];
            return response($response);
        }
    }

}
