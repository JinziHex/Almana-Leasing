<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\City_location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CustomiseLanaguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
            try
            {
                $pageTitle="Language Customization";
                $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
                $far=json_decode($lang_file_ar,true);
                $data=[];
                $fars=array_merge($far,$data);
                return view('admin.elements.language-customization.index',compact('fars','pageTitle'));
                
            
            }
            catch (\Exception $e) {
                
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
               
             }catch (\Throwable $e) {
               
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
             }

        
    }

    public function add()
    {
        $pageTitle="Add-Language";
        $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
        $far=json_decode($lang_file_ar,true);
        $data=[];
        $fars=array_merge($far,$data);
        return view('admin.elements.language-customization.add',compact('fars','pageTitle'));
    }
    public function store(Request $request)
    {
        $request->validate([   
            'english' => 'required',
            'arabic' => 'required']);
            try
            {
            $city=City::where('city_name',$request->english)->first();
            if($city)
            {
                $city->ar_city_name=$request->arabic;
                $city->update();
            }
            $location=City_location::where('location_name',$request->english)->first();
            if($location)
            {
                $location->ar_location_name=$request->arabic;
                $location->update();
            }
        
        $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
        $far=json_decode($lang_file_ar,true);
        $data = [
                    $request->english  => $request->arabic
                ];
        $result_ar = array_merge($far,$data);
        file_put_contents(resource_path('lang/'.'ar'.'.json'),json_encode($result_ar,JSON_PRETTY_PRINT));
        return redirect()->back()->with('status','Added Successfully');
            }
            catch (\Exception $e) {
                
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
               
             }catch (\Throwable $e) {
               
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
        
             }
    }
}
