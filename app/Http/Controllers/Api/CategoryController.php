<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_category;
use App\Models\Maker;
use App\Models\Modal;
use App\Models\Model_image;
use Crypt;
use Auth;
use Hash;
use Carbon;
use Exception;
use Validator;

class CategoryController extends Controller
{
    
     public function list(Request $request)
    {
        $data = array();
        try {
            $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
            $far=json_decode($lang_file_ar,true);
            $dat=[];
            $categories=Model_category::orderBy('model_cat_id','DESC')->get();
             $fars=array_merge($far,$dat);
            foreach($categories as $category){
                        if(isset($fars[$category->model_cat_name]))
                        {
                        $category->model_cat_name_Arb=$fars[$category->model_cat_name];
                        }
                        else
                        {
                        $category->model_cat_name_Arb=$category->model_cat_name;
                            
                        }
                }
            $data['cateDet'] =$categories;
            return response($data);
       
        }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];

            return response($response);
        }
    }
    
    
    public function webcategorylist(Request $request)
    {
        $data = array();
        try {
            // $data['cateDet'] = Model_category::select('model_cat_id','model_cat_name')->orderBy('model_cat_id','DESC')->get();
            //  $data['cateDet']= Model_category::whereIn('model_cat_id',function($query) {
            //               $query->select('modal_category')->from('modals');
            //               })->select('model_categories.model_cat_id','model_categories.model_cat_name')->groupBy('.model_cat_id')->get();
                          
                $data['cateDet']= Modal::join('model_categories', 'modals.modal_category', '=', 'model_categories.model_cat_id')->where('modals.modal_name','!=',NULL)->where('modals.active_flag','=',1)->whereIn('modal_id',function($query) {
                          $query->select('model_id')->from('model_images');
                          })->select('model_categories.model_cat_id','model_categories.model_cat_name')->groupBy('model_categories.model_cat_id')->get();
            
           
            
            return response($data);
       
        }catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];

            return response($response);
        }
    }
    

     public function makerList(Request $request)
    {
        $data = array();
        try {
                $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
                $far=json_decode($lang_file_ar,true);
                $dat=[];
                $makers=Maker::where('maker_name','!=','Not Defined')->orderBy('maker_id','DESC')->get();
                $fars=array_merge($far,$dat);
                foreach($makers as $maker){
                        if(isset($fars[$maker->maker_name]))
                        {
                        $maker->maker_name_Arb=$fars[$maker->maker_name];
                        }
                        else
                        {
                        $maker->maker_name_Arb=$maker->maker_name;
                            
                        }
                }
                $data['cateDet']=$makers;
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
