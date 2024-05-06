<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Slider;
use Illuminate\Http\Request;
use Validator;
use Crypt;
use Auth;
use Image;

class SliderController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
        	$pageTitle = "Sliders";
           
        	$sliders = Slider::orderBy('id','DESC')->get();
        	return view('admin.elements.sliders.index',compact('pageTitle','sliders'));
          
          

        }else{
            return redirect('/login');
        }
    }
    public function create(Request $request)
    {
        if (Auth::check())
        {
        	$pageTitle = "Create Slider";
            try{
        	return view('admin.elements.sliders.create',compact('pageTitle'));
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
            return redirect('/login');
        }   
    }
/////////////////

    public function save(Request $request, Slider $slider)
    {
        //  dd($request->all());

        $validator = Validator::make($request->all(), [   
                    'slider_image' => 'required|mimes:png,jpg,jpeg',
                  
                ]);

        if (!$validator->fails()) 
        {
            try{
            
        
            if ($request->hasFile('slider_image'))
             {
                $validator = Validator::make($request->all(), [   
                    'slider_image' => 'required|mimes:png,jpg,jpeg',
                ]);
              if($validator->fails())
               {
                 return redirect()->back()->withErrors($validator->errors())->withInput();
              }
                
                $file = $request->file('slider_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/uploads/sliders', $filename);
                $slider->slider_name = $filename;
            }
            $slider->save();

            //    locz
               

             



            return redirect('/admin/sliders')->with('status','slider added Successfully');
            }
            catch (\Exception $e)
                {
                   
                   return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
              
                }
               catch (\Throwable $e)
               {
              
               return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
               }

        }
           else
            {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
       }
    /////////////////////
    // public function save(Request $request)
    // {
    	
    //     $validator = Validator::make($request->all(), [   
    //         'spec_name' => 'required|unique:specifications', 
    //         'ar_spec_name' => 'required|max:150',
    //         'spec_icon' => 'required|mimes:png,jpg,jpeg|max:1024',
          
    //     ],
    //     [ 	'spec_name.unique' => "Specification name is already taken",
    //     	'spec_name.required' => "Specification name is required",
    //         'ar_spec_name.required' => "Specification  name (Arabic) is required"

    //     ]);
    //     if(!$validator->fails())
    //     {
    //         try{
    //         $data= $request->except('_token');
    //         $spec=new Specification();
    //         $spec->spec_name = $request->spec_name;
    //         $spec->ar_spec_name  = $request->ar_spec_name;
    //         $spec->save();
             
    //         $currDetail = Specification::insertGetId($data);
    //        // dd($currDetail);
    //         if ($request->hasFile('spec_icon'))
    //         {
    //             $validator = Validator::make($request->all(), [   
    //                 'spec_icon' => 'required|mimes:png,jpg,jpeg|max:1024',
    //             ]);
    //             if($validator->fails())
    //             {
    //                 return redirect()->back()->withErrors($validator->errors())->withInput();
    //             }
    //             $photo = $request->file('spec_icon'); 

    //                     $storyimagename = time() . '.' . $photo->getClientOriginalExtension();

    //                     $destinationPath = 'assets/uploads/specifications/icons';
    //                     $thumb_img = Image::make($photo->getRealPath())->resize(50,50);
    //                     $thumb_img->save($destinationPath . '/' .$storyimagename, 80);

    //                     $resImgId = Specification::where('spec_id','=',$currDetail)->update
    //                     ([
    //                         'spec_icon'    =>  $storyimagename, 
    //                         'updated_at'  =>  \Carbon\Carbon::now(),
    //                     ]);
    //         }
    //            //locz
               

    //            $lang_file_en = file_get_contents(resource_path('lang/'.'en'.'.json'));
    //            $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
    //            $fen=json_decode($lang_file_en,true);
    //            $far=json_decode($lang_file_ar,true);
    //            $data_ar = [
    //                $spec->spec_name  => $spec->ar_spec_name,
                   
    //            ];
    //            $data_en = [
    //                $spec->spec_name  => $spec->spec_name,
    //            ];
    //            $result_en = array_merge($fen,$data_en);
    //            $result_ar = array_merge($far,$data_ar);
    //            file_put_contents(resource_path('lang/'.'en'.'.json'),json_encode($result_en,JSON_PRETTY_PRINT));
    //            file_put_contents(resource_path('lang/'.'ar'.'.json'),json_encode($result_ar,JSON_PRETTY_PRINT));
    //     }
    //      catch (\Exception $e)
    //     {
           
    //        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
      
    //     }
    //    catch (\Throwable $e)
    //    {
      
    //    return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    //    }
        
    //       return redirect('/admin/specification')->with('status','Specification added Successfully');
    //     }
    //     else
    //     {
    //         return redirect()->back()->withErrors($validator->errors())->withInput();
    //     }
    // }

   
   
    public function delete($id)
    {
    	$decryptId = Crypt::decryptString($id);
    	
            try{

    	    Slider::where('id',$decryptId)->delete();
    	    return back()->with('status','Deleted Slider');
            }
            catch (\Exception $e)
            {
         
           return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
           }
            catch (\Throwable $e)
              {
    
              return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
              }

    	
    	
    
    }
   
}
