<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modal;
use App\Models\Maker;
use App\Models\Rate_type;
use App\Models\Model_group;
use App\Models\City;
use App\Models\City_location;
use App\Models\Model_image;
use App\Models\Model_category;
use App\Models\Model_specification;
use App\Models\Specification;
use App\Models\Mode_rate;
use App\Models\Traffic_Violation;
use Illuminate\Support\Facades\Http;
use Image;
use Crypt;
use Auth;
use GuzzleHttp\Client;

class ApiConnectController extends Controller
{
    
    public function addMakers()
    {
        
            try {

           
            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://130.61.97.192:201/F_CAR_MAKE');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            $item = $response['Items'];
            
            // $oneItem = $item['0'];
            // dd($oneItem);
            
            foreach($response['Items'] as $element) {
                $makerName = $element['FCM_ENAME'];
                $makerId = $element['FCM_MAKE_NO'];
                if($makerName!=NULL)
                {
                    Maker::updateOrCreate([
                        'maker_id' => $makerId
                    ],[
                        'maker_name' => $makerName,
                        'maker_id' => $makerId
                    ]
                    );
                    
                }
            }
            return "maker updated";
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    public function addModelCategory()
    {
         try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://130.61.97.192:201/F_CATEGORY');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            
            // $item = $response['Items'];
            foreach($response['Items'] as $element) {
                $modelCatName = $element['FC_NAME'];
                $fcCode=$element['FC_CODE'];
                
                Model_category::updateOrCreate([
                        'model_cat_id' => $fcCode
                    ],
                    [
                        'model_cat_id' => $fcCode,
                        'model_cat_name' => $modelCatName
                    ]);
                
            }
            return "model category updated";
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    public function addRateTypes()
    {
        
            try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://130.61.97.192:201/F_CAR_RATES');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            
            foreach($response['Items'] as $element) {
                $rateCode = $element['FCR_CODE'];
                $rateTypeName = $element['FCR_NAME'];
                $rateTypeDays = $element['FCR_DAYS'];
                
                Rate_type::updateOrCreate(
                    [
                        'rate_type_code' => $rateCode,
                    ],[
                        'rate_type_code' => $rateCode,
                        'rate_type_name' => $rateTypeName,
                        'rate_type_days' => $rateTypeDays,
                    ]);
                
            }
            return "rate type updated";
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    public function addModelGroup()
    {
        
            try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://rentsolution.dyndns.info:200/F_CAR_GROUPS');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true);
            
            
            foreach($response['Items'] as $element) {
                $groupCode = $element['FCG_GRP_CODE'];
                $groupName = $element['FCG_GRP_NAME'];
                
                
                Model_group::firstOrCreate([
                        'group_code' => $groupCode,
                        'group_name' => $groupName,
                    ]);
                
            }
            dd("success");
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    
    public function addModels()
    {
        
            try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://130.61.97.192:201/F_CAR_MODEL_VIEW');
            
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            
            
            foreach($response['Items'] as $element) {
                $makerId = $element['FCM_MAKE_NO'];
                $modelId=$element['FCM_MODEL_NO'];
                $modelName = $element['FCM_ENAME'];
                $modelCategory = $element['FCM_CATEGORY_CODE'];
                $groupCode =  $element['FCM_GROUP'];
                $rdyCount =  $element['RDY_COUNT'];
                $fetchGroup = Model_group::where('group_code','=',$groupCode)->first();
                $groupId = @$fetchGroup['group_id'];
                
                
                Modal::updateOrCreate(
                    [
                        'model_number'=>$modelId,
                        'makers' => $makerId,
                        'modal_category' => $modelCategory,
                    ],
                     [
                        'model_number'=>$modelId,
                        'modal_name' => $modelName,
                        'modal_category' => $modelCategory,
                        'makers' => $makerId,
                        'group_id' => $groupId,
                        'rdy_count' => $rdyCount,
                        
                    ]);
                
            }
            dd("success");
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    public function addModelRates()
    {
        
        
            try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://130.61.97.192:201/MODEL_RATES_VIEW');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            
            foreach($response['Items'] as $element) {
                $makerId = $element['MAKE'];
                $modelId = $element['MODEL'];
                $modelYear = $element['MODEL_YEAR'];
                $rateTypeCode = $element['RATE_CODE'];
                $fetchRateType = Rate_type::where('rate_type_code','=',$rateTypeCode)->first();
                $rateTypeId = $fetchRateType['rate_type_id'];
                $rate =  $element['RATE'];
                $minRate = $element['MIN_RATE'];
                
                Mode_rate::updateOrCreate(
                    [
                        'maker_id' => $makerId,
                        'model_id' => $modelId,
                        'model_year' => $modelYear,
                        'rate_type_id' => $rateTypeId,
                        'rate_code' => $rateTypeCode,
                    ],
                    [
                        'maker_id' => $makerId,
                        'model_id' => $modelId,
                        'model_year' => $modelYear,
                        'rate_type_id' => $rateTypeId,
                        'rate_code' => $rateTypeCode,
                        'rate' =>$rate,
                        'model_min_rate' => $minRate,
                    ]);
                
            }
            dd("success");
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    public function addCity()
    {
        
            try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://rentsolution.dyndns.info:200/F_CITY');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            dd($response);
            
            foreach($response['Items'] as $element) {
                $cityName = $element['FC_CITY_NAME'];
                
                
                City::firstOrCreate([
                        
                        'country_id' => '174',
                        'city_name' => $cityName,
                    ]);
                
            }
            dd("success");
           
            
          
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    public function addCityLocation()
    {
        
            try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://rentsolution.dyndns.info:200/F_CITY_LOC');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            dd($response);
            
            foreach($response['Items'] as $element) {
                $cityId = $element['FCL_CITY_CODE'];
                $locationName = $element['FCL_LOC_NAME'];
                
                
                City_location::firstOrCreate([
                        'city_id' => $cityId,
                        'location_name' => $locationName,
                    ]);
                
            }
            dd("success");
           
            
          
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    public function violationList()
    {
        
            try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://rentsolution.dyndns.info:200/TRAFFIC_VIOLATION_VIEW');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            
            
            foreach($response['Items'] as $element) {
                $voucherNo = $element['VOUCHER_NO'];
                $modelRegNo = $element['REG_NO'];
                $voucherDate = $element['VOUCHER_DATE'];
                $custCode = $element['CUSTOMER_CODE'];
                $custName = $element['CUSTOMER_NAME'];
                $narration = $element['NARRATION'];
                $violateDate = $element['VIOLATION_DATE'];
                $violateLocation = $element['VIOLATION_LOC'];
                $raNo = $element['RA_NO'];
                $raType = $element['RA_TYPE'];
                $moiReg = $element['MOI_REG'];
                

                Traffic_Violation::create([
                        
                        'voucher_no' => $voucherNo,
                        'customer_id' => $custCode,
                        'voucher_date' => $voucherDate,
                        'customer_name' => $custName,
                        'violation_location' => $violateLocation,
                        'ra_no' => $raNo,
                        'ra_type' => $raType,
                        'moi_reg' => $moiReg,
                        'model_reg_no' => $modelRegNo,
                        'violation_content' => $narration,
                        'violation_date' => $violateDate,
                    ]);
                
            }
            dd("success");
           
            
          
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    

    
}
