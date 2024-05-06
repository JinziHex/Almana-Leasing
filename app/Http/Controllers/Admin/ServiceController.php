<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mst_service;
use App\Models\Mst_page_data;
use Illuminate\Support\Str;
use Validator;
use Crypt;
use Auth;
use Image;

class ServiceController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }
    public function listServices()
    {
        try{
            $pageTitle = "Service Contents";
            $fetchDetail = Mst_service::orderBy('service_id','DESC')->get();
            return view('admin.elements.service.list',compact('fetchDetail','pageTitle'));
        }
        catch (\Exception $e) {
                
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
       
     }catch (\Throwable $e) {
       
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

     }

    }

    public function addService()
    {
    	$pageTitle = "Add New Service";
    	return view('admin.elements.service.add',compact('pageTitle'));
    }

    public function saveService(Request $request, Mst_service $services)
    {
    	$validator = Validator::make($request->all(), [   
                'service_title' => 'required',
                'service_description' => 'required',
                // 'service_image_1' => 'required|mimes:png,jpg,jpeg',
                // 'service_image_2' => 'required|mimes:png,jpg,jpeg',
                // 'service_content_title' => 'required',
                // 'service_content_description' => 'required',
        ]);
        if(!$validator->fails())
            {
                try{
            	$services->service_title = $request->service_title;
                $services->ar_service_title = $request->ar_service_title;
                $services->service_slug =   Str::of($request->service_title)->slug('-');
            	$services->service_description =  $request->service_description;
                $services->ar_service_description =  $request->ar_service_description;
            	$services->service_content_title = $request->service_content_title;
                $services->ar_service_content_title = $request->ar_service_content_title;
            	$services->service_content_description =$request->service_content_description;
                $services->ar_service_content_description =$request->ar_service_content_description;
                
                //localisation
                $services->save();
                $lang_file_en = file_get_contents(resource_path('lang/'.'en'.'.json'));
                $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
                $fen=json_decode($lang_file_en,true);
                $far=json_decode($lang_file_ar,true);
                $data_ar = [
                    $services->service_title  => $services->ar_service_title,
                    $services->service_description  => $services->ar_service_description,
                    $services->service_content_title  => $services->ar_service_content_title,
                    $services->service_content_description  => $services->ar_service_content_description


                ];
                $data_en = [
                    $services->service_title  => $services->service_title,
                    $services->service_description  => $services->service_description,
                    $services->service_content_title  => $services->service_content_title,
                    $services->service_content_description  => $services->service_content_description


                ];
                $result_en = array_merge($fen,$data_en);
                $result_ar = array_merge($far,$data_ar);
                file_put_contents(resource_path('lang/'.'en'.'.json'),json_encode($result_en,JSON_PRETTY_PRINT));
                file_put_contents(resource_path('lang/'.'ar'.'.json'),json_encode($result_ar,JSON_PRETTY_PRINT));
                $getId = $services->service_id;

            	if ($request->hasFile('service_image_1'))
                    {
                                $photo = $request->file('service_image_1'); 
                                $storyimagename = time() . '.' . $photo->getClientOriginalExtension();
                                $destinationPath = 'assets/uploads/service';
                                $thumb_img = Image::make($photo->getRealPath());
                                $thumb_img->save($destinationPath . '/' .$storyimagename, 80);
                                // $services->service_image_1 = $storyimagename;
                                Mst_service::where('service_id','=',$getId)->update([
                                    'service_image_1' => $storyimagename
                                ]);
                    }
                if ($request->hasFile('service_image_2'))
                    {
                                $photo2 = $request->file('service_image_2'); 
                                $storyimagename2 = time() . '.' . $photo2->getClientOriginalExtension();
                                $destinationPath2 = 'assets/uploads/service';
                                $thumb_img2 = Image::make($photo2->getRealPath());
                                $thumb_img2->save($destinationPath2 . '/' .$storyimagename2, 80);
                                // $services->service_image_2 = $storyimagename2;
                                Mst_service::where('service_id','=',$getId)->update([
                                    'service_image_2' => $storyimagename2
                                ]);
                    }

                if ($request->hasFile('service_icon'))
                    {
                                $ServicePhoto = $request->file('service_icon'); 
                                $serviceIcon = time() . '.' . $ServicePhoto->getClientOriginalExtension();
                                $iconDestination = 'assets/uploads/service/icons';
                                $thumb_imgService = Image::make($ServicePhoto->getRealPath());
                                $thumb_imgService->save($iconDestination . '/' .$serviceIcon, 80);
                                // $services->service_icon = $serviceIcon;
                                 Mst_service::where('service_id','=',$getId)->update([
                                    'service_icon' => $serviceIcon
                                ]);
                    }
                
                return redirect('admin/services')->with('status','Added Service');
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

    
    public function editService($id, Request $request)
    {
        try{
        $decrId = Crypt::decryptString($id);
        $pageTitle = "Edit Service Contents";
        $fetchDetail = Mst_service::where('service_id','=',$decrId)->first();
        return view('admin.elements.service.edit',compact('pageTitle','fetchDetail'));
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

    
    public function updateService(Request $request)
    {
        try{
        $getId = $request->service_id;
        $mstService = Mst_service::Find($getId);

                $mstService->service_title = $request->service_title;
                $mstService->ar_service_title = $request->ar_service_title;
                $mstService->service_slug =   Str::of($request->service_title)->slug('-');
                $mstService->service_description = $request->service_description;
                $mstService->ar_service_description = $request->ar_service_description;
                $mstService->service_content_title = $request->service_content_title;
                $mstService->ar_service_content_title = $request->ar_service_content_title;
                $mstService->service_content_description = $request->service_content_description;
                $mstService->ar_service_content_description = $request->ar_service_content_description;


                if ($request->hasFile('service_image_1'))
                {
	                if ($request->file('service_image_1')->isValid()) 
	                    {
	                        $catimage = Mst_service::where('service_id','=',$getId)->first();
	                        $proimg=$catimage->service_image_1;   
	                            
	                                if($proimg!="")
                                        {
                                            $path =  "assets/uploads/service/".$proimg;

                                            if(file_exists($path))
                                            {
                                                unlink('assets/uploads/service/'.$proimg);
                                            }
                                        }
	                                    
	                                    $photo=$request->file('service_image_1');
	                                    $certLogoImage = time() . '.' . $photo->getClientOriginalExtension();
	                                    $destinationPath = 'assets/uploads/service';
	                                    $thumb_img = Image::make($photo->getRealPath());
	                                    $thumb_img->save($destinationPath . '/' .$certLogoImage);
	                                    $mstService->service_image_1 = $certLogoImage; 
                                        Mst_service::where('service_id','=',$getId)->update([

                                            'service_image_1' => $certLogoImage
                                     ]);

	                    }
            	}

            	if ($request->hasFile('service_image_2'))
                {
	                if ($request->file('service_image_2')->isValid()) 
	                    {
	                        $catimage22 = Mst_service::where('service_id','=',$getId)->first();
	                        $proimg2=$catimage22->service_image_2;   
	                            
	                               if($proimg2!="")
                                        {
                                            $path1 =  "assets/uploads/service/".$proimg2;

                                            if(file_exists($path1))
                                            {
                                                unlink('assets/uploads/service/'.$proimg2);
                                            }
                                        }
	                                    
	                                    $photosec=$request->file('service_image_2');
	                                    $certLogoImage2 = time().'1' . '.' . $photosec->getClientOriginalExtension();
	                                    $destinationPath2 = 'assets/uploads/service';
	                                    $thumb_img2 = Image::make($photosec->getRealPath());
	                                    $thumb_img2->save($destinationPath2 . '/' .$certLogoImage2);
	                                    $mstService->service_image_2 = $certLogoImage2; 
                                        Mst_service::where('service_id','=',$getId)->update([

                                            'service_image_2' => $certLogoImage2
                                        ]);

	                    }
            	}

                if ($request->hasFile('service_icon'))
                {
                    if ($request->file('service_icon')->isValid()) 
                        {
                            $serviceIconImage = Mst_service::where('service_id','=',$getId)->first();
                            $servImg=$serviceIconImage->service_icon;   
                                
                                   if($servImg!="")
                                        {
                                            $path1 =  "assets/uploads/service/icons/".$servImg;

                                            if(file_exists($path1))
                                            {
                                                unlink('assets/uploads/service/icons/'.$servImg);
                                            }
                                        }
                                        
                                        $ServicePhoto = $request->file('service_icon'); 
                                        $serviceIcon = time() . '.' . $ServicePhoto->getClientOriginalExtension();
                                        $iconDestination = 'assets/uploads/service/icons';
                                        $thumb_imgService = Image::make($ServicePhoto->getRealPath());
                                        $thumb_imgService->save($iconDestination . '/' .$serviceIcon, 80);
                                        Mst_service::where('service_id','=',$getId)->update([

                                            'service_icon' => $serviceIcon
                                        ]);

                        }
                }
               
            	$mstService->update();
        
        return redirect('admin/services')->with('status','Service Updated');
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

    
    public function deleteService($id)
    {
       try{

        $decrId = Crypt::decryptString($id);
        $fetchContent = Mst_service::Find($decrId);
        $serviceImg1 = $fetchContent->service_image_1;
        $serviceImg2 = $fetchContent->service_image_2;
        $serviceIcon = $fetchContent->service_icon;
        if($serviceImg1!="")
            {
                $path1 =  "assets/uploads/service/".$serviceImg1;

                    if(file_exists($path1))
                        {
                            unlink('assets/uploads/service/'.$serviceImg1);
                        }
            }
        if($serviceImg2!="")
            {
                $path2 =  "assets/uploads/service/".$serviceImg2;

                    if(file_exists($path2))
                        {
                            unlink('assets/uploads/service/'.$serviceImg2);
                        }
            }
        
        if($serviceIcon!="")
            {
                $path3 =  "assets/uploads/service/icons/".$serviceIcon;

                    if(file_exists($path3))
                        {
                            unlink('assets/uploads/service/icons/'.$serviceIcon);
                        }
            }

        Mst_service::where('service_id','=',$decrId)->delete();
        return back()->with('status','Service Deleted');
       }
       catch (\Exception $e) {
                
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
   
        }catch (\Throwable $e) {
        
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

        }

    }

    public function fetchBanner()
    {
        try
        {
            $fetchDetail = Mst_page_data::where('page_name','=','service')->first();
        $pageTitle = "Service Banner";
        return view('admin.elements.service.banner',compact('pageTitle','fetchDetail'));
        }
        catch (\Exception $e) 
        {
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
           
         }
         catch (\Throwable $e) {
           
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
    
         }
        
    }
       

    



}
