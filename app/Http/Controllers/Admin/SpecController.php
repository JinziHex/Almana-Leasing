<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Specification;
use App\Models\Model_specification;
use Validator;
use Crypt;
use Auth;
use Image;

class SpecController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
        	$pageTitle = "Specification";
            try{
        	$specDetail = Specification::orderBy('spec_id','DESC')->get();
        	return view('admin.elements.specification.index',compact('pageTitle','specDetail'));
            }
            catch (\Exception $e) {
                
                return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         
        }

        }else{
            return redirect('/login');
        }
    }
    public function add(Request $request)
    {
        if (Auth::check())
        {
        	$pageTitle = "Add Specification";
            try{
        	return view('admin.elements.specification.add',compact('pageTitle'));
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

    public function save(Request $request, Specification $specification)
    {
        //  dd($request->all());

        $validator = Validator::make($request->all(), [   
                    'spec_name' => 'required|unique:specifications', 
                    'ar_spec_name' => 'required|max:150',
                    'spec_icon' => 'required|mimes:png,jpg,jpeg|max:1024',
                  
                ],
                [ 	'spec_name.unique' => "Specification name is already taken",
                	'spec_name.required' => "Specification name is required",
                    'ar_spec_name.required' => "Specification  name (Arabic) is required"
        
                ]);

        if (!$validator->fails()) 
        {
            try{
            $data = $request->except('_token');
            $specification->spec_name = $request->spec_name;
            $specification->ar_spec_name  = $request->ar_spec_name;
        
            if ($request->hasFile('spec_icon'))
             {
                $validator = Validator::make($request->all(), [   
                    'spec_icon' => 'required|mimes:png,jpg,jpeg|max:1024',
                ]);
              if($validator->fails())
               {
                 return redirect()->back()->withErrors($validator->errors())->withInput();
              }
                
                $file = $request->file('spec_icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move('assets/uploads/specifications/icons', $filename);
                $specification->spec_icon = $filename;
            }
            $specification->save();

            //    locz
               

               $lang_file_en = file_get_contents(resource_path('lang/'.'en'.'.json'));
               $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
               $fen=json_decode($lang_file_en,true);
               $far=json_decode($lang_file_ar,true);
               $data_ar = [
                   $specification->spec_name  => $specification->ar_spec_name,
                   
               ];
               $data_en = [
                   $specification->spec_name  => $specification->spec_name,
               ];
               $result_en = array_merge($fen,$data_en);
               $result_ar = array_merge($far,$data_ar);
               file_put_contents(resource_path('lang/'.'en'.'.json'),json_encode($result_en,JSON_PRETTY_PRINT));
               file_put_contents(resource_path('lang/'.'ar'.'.json'),json_encode($result_ar,JSON_PRETTY_PRINT));



            return redirect('/admin/specification')->with('status','Specification added Successfully');
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

    public function edit($id, Request $request)
    {
        if (Auth::check())
        {
        
            $specId = Crypt::decryptString($id);
        	$pageTitle = "Edit Specification";
            try{
        	$resUpdate = Specification::where('spec_id','=',$specId)->first();
        	return view('admin.elements.specification.edit',compact('pageTitle','specId','resUpdate'));
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
            return redirect('/login');
        }
    }
    public function update(Request $request, Specification $specification)
    {
        try{
    	$specId = $request->input('specification_id');
    	$specification = Specification::Find($specId);
        

        $icons = $request->file('spec_icon');

                if ($request->hasFile('spec_icon'))
                {
                    if ($request->file('spec_icon')->isValid()) 
                        {

                            $catimage=Specification::where('spec_id','=',$specId)->get();
                         
                            foreach ($catimage as $key => $value) 
                            {
                                $proimg=$value->spec_icon;
                                

                            }

                             if($proimg!="")
                                        {
                                            $path =  "assets/uploads/specifications/icons/".$proimg;

                                            if(file_exists($path))
                                            {
                                                unlink('assets/uploads/specifications/icons/'.$proimg);
                                            }
                                        }
                            
                           

                             $icons = $request->file('spec_icon');
                            $specImage = time().'.'.$icons->getClientOriginalExtension(); 
                            $destinationPath = 'assets/uploads/specifications/icons';
                            $thumb_img = Image::make($icons->getRealPath())->resize(50,50);
                           
                            $thumb_img->save($destinationPath.'/'.$specImage,80);

                            Specification::where('spec_id',$specId)->update([

                                'spec_icon' =>  $specImage,

                            ]);               
                        }
                }

    	$specification->spec_name = $request->input('spec_name');
        $specification->ar_spec_name = $request->input('ar_spec_name');
    	$specification->save();

               //locz
               
               $lang_file_en = file_get_contents(resource_path('lang/'.'en'.'.json'));
               $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
               $fen=json_decode($lang_file_en,true);
               $far=json_decode($lang_file_ar,true);
               $data_ar = [
                   $specification->spec_name  => $specification->ar_spec_name,
                   
               ];
               $data_en = [
                   $specification->spec_name  => $specification->spec_name,
               ];
               $result_en = array_merge($fen,$data_en);
               $result_ar = array_merge($far,$data_ar);
               file_put_contents(resource_path('lang/'.'en'.'.json'),json_encode($result_en,JSON_PRETTY_PRINT));
               file_put_contents(resource_path('lang/'.'ar'.'.json'),json_encode($result_ar,JSON_PRETTY_PRINT));
    	return redirect('/admin/specification')->with('status','Specification Updated');
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
    public function delete($id)
    {
    	$decryptId = Crypt::decryptString($id);
    	$checkExistnce = Model_specification::where('spec_id',$decryptId)->get();
    	if(!$checkExistnce->isEmpty())
    	{
    	    return back()->with('status','Unable to delete. Models Exists with this specification, Please unlink the models and try again.');
    	}else
        {
            try{
    	   	Model_specification::where('spec_id',$decryptId)->delete();
    	    Specification::where('spec_id',$decryptId)->delete();
    	    return back()->with('status','Deleted Specification');
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
    public function deactivate($id)
    {   
        $decryptId = Crypt::decryptString($id);
        Specification::where('spec_id','=',$decryptId)->update([
            'active_flag' => 0
        ]);
        Model_specification::where('spec_id','=',$decryptId)->update([
            'is_active' => 0
        ]);
        return back()->with('status','Specification Hidden');
    }
    
    public function activate($id)
    {   
        $decryptId = Crypt::decryptString($id);
        Specification::where('spec_id','=',$decryptId)->update([
            'active_flag' => 1
        ]);
         Model_specification::where('spec_id','=',$decryptId)->update([
            'is_active' => 1
        ]);
        return back()->with('status','Specification Active');
    }


}
