<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Image;
use Crypt;
use Auth;
use Validator;
use GuzzleHttp\Client;

class ModelController extends Controller
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
                    Maker::firstOrCreate([
                        'maker_name' => $makerName,
                        'maker_id' => $makerId
                    ]);
                    
                }
                
                
            }
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    public function addModelCategory()
    {
        
            try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://rentsolution.dyndns.info:200/F_CATEGORY');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            
            // $item = $response['Items'];
            foreach($response['Items'] as $element) {
                $modelCatName = $element['FC_NAME'];
                
                Model_category::firstOrCreate([
                        'model_cat_name' => $modelCatName
                    ]);
                
            }
            } catch (\Exception $e) {

            $response = ['status' => false, 'message' => $e->getMessage()];
            return $response;

            }
            
    }
    
    
    public function addRateTypes()
    {
        
            try {

            $client = new \GuzzleHttp\Client();
            $api = $client->get('http://rentsolution.dyndns.info:200/F_CAR_RATES');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            
            foreach($response['Items'] as $element) {
                $rateCode = $element['FCR_CODE'];
                $rateTypeName = $element['FCR_NAME'];
                $rateTypeDays = $element['FCR_DAYS'];
                
                Rate_type::firstOrCreate([
                        'rate_type_code' => $rateCode,
                        'rate_type_name' => $rateTypeName,
                        'rate_type_days' => $rateTypeDays,
                    ]);
                
            }
            dd("success");
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
            $api = $client->get('http://rentsolution.dyndns.info:200/F_CAR_MODEL_VIEW');
            
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
           
            
            foreach($response['Items'] as $element) {
                $makerId = $element['FCM_MAKE_NO'];
                $modelName = $element['FCM_ENAME'];
                $modelCategory = $element['FCM_CATEGORY_CODE'];
                $groupCode =  $element['FCM_GROUP'];
                $fetchGroup = Model_group::where('group_code','=',$groupCode)->first();
                $groupId = $fetchGroup['group_id'];
                
                
                Modal::firstOrCreate([
                        'modal_name' => $modelName,
                        'modal_category' => $modelCategory,
                        'makers' => $makerId,
                        'group_id' => $groupId
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
            $api = $client->get('http://rentsolution.dyndns.info:200/MODEL_RATES_VIEW?LookupText=&PageSize=1&Skip=0&MAKE=1&MODEL=5&MODEL_YEAR=2012&RATE_CODE=D');
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            dd($response);
           
            
            foreach($response['Items'] as $element) {
                $makerId = $element['MAKE'];
                $modelId = $element['MODEL'];
                $modelYear = $element['MODEL_YEAR'];
                $rateTypeCode = $element['RATE_CODE'];
                $fetchRateType = Rate_type::where('rate_type_code','=',$rateTypeCode)->first();
                $rateTypeId = $fetchGroup['rate_type_id'];
                $rate =  $element['RATE'];
                $minRate = $element['MIN_RATE'];
                
                Mode_rate::firstOrCreate([
                        'maker_id' => $makerId,
                        'model_id' => $modelId,
                        'model_year' => $modelYear,
                        'rate_type_id' => $rateTypeId,
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


    public function addModel()
    {
        if (Auth::check())
        {
        	$pageTitle = "Add Model";
            $listCategory = Model_category::orderBy('model_cat_name','ASC')->get();
            $listMaker = Maker::where('maker_id','!=',29)->orderBy('maker_name','ASC')->get();
            $showSPec = Specification::orderBy('spec_id','DESC')->get();
            $listGroup = Model_group::orderBy('group_name','ASC')->get();
        	return view('admin.elements.model.add',compact('pageTitle','listCategory','listMaker','showSPec','listGroup'));
        }else{
            return redirect('/login');
        }
    }
    
    
    
    public function index(Request $request)
    {
        if (Auth::check())
        {
        	$pageTitle = "Models";
            $modal=Modal::orderBy('modal_id','ASC')->get();
            $modalCategory=Model_category::orderBy('model_cat_id','ASC')->get();
            $maker=Maker::orderBy('maker_id','ASC')->get();

        	$modDetail = Modal::where('modal_name','!=',NULL)->orderBy('modal_id','ASC')->get();

        	$modSpec 	= Specification::where('active_flag','=',1)->orderBy('spec_name','ASC')->get();

            // filter
            if ($_GET) {
            
                $modal_id  = $request->modal;
                $modal_category = $request->category;
                $makers =  $request->makers;
                $active_flag =  $request->status;
           

                
			$query = Modal::where('modal_name','!=',NULL)->select('modals.*')
            ->leftjoin('model_categories', 'model_categories.model_cat_id', '=', 'modals.modal_category')
            ->leftjoin('makers', 'makers.maker_id', '=', 'modals.makers');
       
           
            
            if (isset($modal_id)) {
				$query = $query->where('modals.modal_id', $modal_id);
			}
            if (isset($modal_category)) {
				$query = $query->where('model_categories.model_cat_id', $modal_category);
			}
          
            if (isset($makers)) {
				$query = $query->where('makers.maker_id', $makers);
			}
       

            if (isset($active_flag)) {
                $query = $query->where('modals.active_flag', $active_flag);
              }
      
          
    
         $modDetail =  $query->paginate(20);

          
            
            return view('admin.elements.model.index',compact('pageTitle','modal','maker','modalCategory','modDetail','modSpec'));
            }
            
        	return view('admin.elements.model.index',compact('pageTitle','modal','maker','modalCategory','modDetail','modSpec'));
        }
        else{
            return redirect('/login');
        }
    }
/////////////////////////////////////
public function modelSave(Request $request, Modal $modal)
    {
        $validator = Validator::make($request->all(), [   
            'modal_name' => 'required|unique:modals',
            'ar_modal_name' => 'required',
            'modal_category' => 'required',
            'makers' =>'required',
            'group_id' => 'required',
            
    ],
    [       'modal_name.required' => "Model name is required",
            'ar_modal_name.required' => "Model name (Arabic) is required",
            'modal_name.unique' => "Model name is already taken",
            'modal_category.required' => "Model Category is required",
            'makers.required' => "Maker is required",
            'group_id.required' => "group_id is required",

            
    ]);
    if(!$validator->fails())
        {
            try{
                $modal->modal_name  = $request->modal_name;
                $modal->ar_modal_name = $request->ar_modal_name;
                $modal->modal_category = $request->modal_category;
                $modal->makers = $request->makers;
                $modal->group_id = $request->group_id;
                
            
            //localisation
            $modal->save();
            $lang_file_en = file_get_contents(resource_path('lang/'.'en'.'.json'));
            $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
            $fen=json_decode($lang_file_en,true);
            $far=json_decode($lang_file_ar,true);
            $data_ar = [
                $modal->modal_name  => $modal->ar_modal_name,
               


            ];
            $data_en = [
                $modal->modal_name  => $modal->service_title,
              


            ];
            $result_en = array_merge($fen,$data_en);
            $result_ar = array_merge($far,$data_ar);
            file_put_contents(resource_path('lang/'.'en'.'.json'),json_encode($result_en,JSON_PRETTY_PRINT));
            file_put_contents(resource_path('lang/'.'ar'.'.json'),json_encode($result_ar,JSON_PRETTY_PRINT));
            $getId = $modal->modal_id ;

            if ($request->hasFile('image'))
             {
                $validator = Validator::make($request->all(), [   
                    'image' => 'required|mimes:png,jpg,jpeg|max:1024',
                ]);
                if($validator->fails())
                {
                    return redirect()->back()->withErrors($validator->errors())->withInput();
                }
            $photo = $request->file('image'); 
            $modelImageName = time() . '.' . $photo['0']->getClientOriginalExtension();
            $i = '0';
            foreach($photo as $photos)
                {
                    $i++;
                    $mulImages = $i . $storyimagename = time() . '.' . $photos->getClientOriginalExtension();
                    $destinationPath = 'assets/uploads/models';
                    $thumb_img = Image::make($photos->getRealPath());
                    $thumb_img->save($destinationPath . '/' . $i . $storyimagename, 80);

                    $resImgId = Model_image::insertGetId([
                        'model_id'    =>  $getId, 
                        'model_image' =>  $mulImages, 
                        'created_at'  =>  \Carbon\Carbon::now(),
                        'updated_at'  =>  \Carbon\Carbon::now(),
                    ]);
                }
               
                $flgCheck = Model_image::where('model_id',$getId)->where('model_image_flag','=','0')->get();
                   
                if($flgCheck->isEmpty())
                {
                    Model_image::where('model_image_id','=',$resImgId)->update([
                    'model_image_flag' => 0
                    ]);
                }
                
            if ($request->specifications) 
            {
                $spec = $request->input('specifications');
                $i = '0';
                    foreach($spec as $specs)
                    {
                        $i++;
                        Model_specification::firstOrCreate([
                        'model_id' => $getId,
                        'spec_id' => $specs,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                        ]);
                    }
            }
                
            return redirect('/admin/models')->with('status','Model added Successfully');
            }
        }
            catch (\Exception $e)
            {
         
           return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
           }
            catch (\Throwable $e)
              {
    
              return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
              }

        }else{
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
}





////////////////////////////////////

    
     
    public function image_save(Request $request)
    {
    	$modalId = $request->input('modal_id');
    	if ($request->hasFile('image'))
           	{
                $validator = Validator::make($request->all(), [   
                    'image' => 'required|max:1024',
                ]);
                if($validator->fails())
                {
                    return redirect()->back()->withErrors($validator->errors())->withInput();
                }
                
                $photo = $request->file('image'); 
                $modelImageName = time() . '.' . $photo['0']->getClientOriginalExtension();
                $i = '0';
                foreach($photo as $photos)
                    {
                        $i++;
                        $mulImages = $i . $storyimagename = time() . '.' . $photos->getClientOriginalExtension();
                        $destinationPath = 'assets/uploads/models';
                        $thumb_img = Image::make($photos->getRealPath());
                        $thumb_img->save($destinationPath . '/' . $i . $storyimagename, 80);

                        $resImgId = Model_image::insertGetId([
                            'model_id'    =>  $modalId, 
                            'model_image' =>  $mulImages, 
                            'created_at'  =>  \Carbon\Carbon::now(),
                            'updated_at'  =>  \Carbon\Carbon::now(),
                        ]);
                    }
                    $flgCheck = Model_image::where('model_id',$modalId)->where('model_image_flag','=','0')->get();
                   
                    if($flgCheck->isEmpty())
                    {
                        Model_image::where('model_image_id','=',$resImgId)->update([
                        'model_image_flag' => 0
                        ]);
                    }
                    
                  return back()->with('status','Image Uploaded');
            }
    }

    public function spec_save(Request $request)
    {
    	$modelId = $request->input('modal_id');
        $spec = $request->input('specifications');
         $i = '0';
            foreach($spec as $specs)
                {
                    $i++;
                    Model_specification::firstOrCreate([
                    'model_id' => $modelId,
                    'spec_id' => $specs,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                    ]);
                }

        return back()->with('status','Specification Added');

    }

    public function view($id, Request $request)
    {
        if (Auth::check())
        {
        	$pageTitle = "Models View";
        	$decryptId = Crypt::decryptString($id);
        	$viewRes = Modal::where('modal_id',$decryptId)->first();
        	$viewSpec = Model_specification::where('model_id','=',$decryptId)->get();
        	$viewImage = Model_image::where('model_id','=',$decryptId)->get();
            // $viewRate   = Mode_rate::where('model_id','=',$decryptId)->orderBy('rate_type_id','ASC')->get();
            $mainImg = Model_image::where('model_id','=',$decryptId)->where('model_image_flag','=',0)->first();
        	return view ('admin.elements.model.view',compact('decryptId','viewRes','viewSpec','viewImage','pageTitle','mainImg'));
        }else{
            return redirect('/login');
        }
    }

    public function edit($id, Request $request)
    {
        if (Auth::check())
        {
            $modId = Crypt::decryptString($id);
            $pageTitle = "Edit Images & Specifications";
            $viewSpec = Model_specification::where('model_id','=',$modId)->get();
            $viewImage = Model_image::where('model_id','=',$modId)->get();
            return view('admin.elements.model.edit',compact('pageTitle','modId','viewSpec','viewImage'));
        }else{
            return redirect('/login');
        }
    }

    public function image_main($id)
    {
        $imageId = Crypt::decryptString($id);
        $fetchModels = Model_image::where('model_image_id','=',$imageId)->first();
        $fetchModelId = $fetchModels->model_id;
        Model_image::where('model_id',$fetchModelId)->update([
            'model_image_flag' => 1
        ]);
        Model_image::where('model_image_id','=',$imageId)->update([
            'model_image_flag' => 0
        ]);
        return back()->with('status','Mode Changed');
    }

    public function image_delete($id)
    {
        $imageId = Crypt::decryptString($id);
        Model_image::where('model_image_id','=',$imageId)->delete();
        return back()->with('status','Deleted Image');
    }

    public function spec_delete($id)
    {
        $imageId = Crypt::decryptString($id);
        Model_specification::where('model_spec_id','=',$imageId)->delete();
        return back()->with('status','Specification Deleted');
    }
    public function hide_model($id)
    {
        $imageId = Crypt::decryptString($id);
        Modal::where('modal_id','=',$imageId)->update([
            'active_flag' =>0
        ]);
        return back()->with('status','Status Changed');
    }
    public function unhide_model($id)
    {
        $imageId = Crypt::decryptString($id);
        Modal::where('modal_id','=',$imageId)->update([
            'active_flag' =>1
        ]);
        return back()->with('status','Status Changed');
    }

    public function fetchModels()
    {
        $resp = Http::get('http://rentsolutions.hexeam.org/api/currency/list');
        dd($resp);
    }

    
}
