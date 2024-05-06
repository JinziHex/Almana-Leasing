<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mst_page_data;
use App\Models\Mst_social_media_icon;
use Validator;
use Crypt;
use Auth;
use Image;


class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function listTerms()
    {
    	$pageTitle = "Terms and Conditions";
    	$fetchTerms = Mst_page_data::where('page_name','=','terms-and-conditions')->first();
    	return view('admin.elements.site-settings.terms-conditions',compact('fetchTerms','pageTitle'));
    }
    
    public function updateData(Request $request)
    {
    	$getId = $request->page_data_id;
        $page_name = $request->page_name;
        
    	$pageDataId = Mst_page_data::Find($getId);
            
    	// $pageDataId->page_banner_title = $request->page_banner_title;
    	$pageDataId->page_banner_description = $request->page_banner_description;

    	// $pageDataId->page_name = $request->page_title;
        
        $pageDataId->ar_page_name = $request->arabic_pagename;
        
    	$pageDataId->page_content = $request->page_content;
        $pageDataId->ar_page_content = $request->ar_page_content;
        
        $pageDataId->page_content_2 = $request->page_content_2;
        $pageDataId->ar_page_banner_title = $request->arabic_page_banner_title;
    	$pageDataId->ar_page_banner_description = $request->arabic_page_banner_description;
        $pageDataId->ar_page_title = $request->arabic_page_title;
        $pageDataId->ar_page_title = $request->arabic_page_title;
        $pageDataId->page_title = $request->page_title;
        $pageDataId->page_title_2 = $request->page_title_2;
        $pageDataId->ar_page_title_2 = $request->ar_page_title_2;
        $pageDataId->page_content_2 = $request->page_content_2;
        $pageDataId->ar_page_content_2 = $request->ar_page_content_2;
        $pageDataId->page_title_3 = $request->page_title_3;
        $pageDataId->ar_page_title_3 = $request->ar_page_title_3;
        $pageDataId->page_content_3 = $request->page_content_3;
        $pageDataId->ar_page_content_3 = $request->ar_page_content_3;
        $pageDataId->page_title_4 = $request->page_title_4;
        $pageDataId->ar_page_title_4 = $request->ar_page_title_4;
        $pageDataId->page_content_4 = $request->page_content_4;
        $pageDataId->ar_page_content_4 = $request->ar_page_content_4;
        $pageDataId->page_title_5 = $request->page_title_5;
        $pageDataId->ar_page_title_5 = $request->ar_page_title_5;
        $pageDataId->page_content_5 = $request->page_content_5;
        $pageDataId->ar_page_content_5 = $request->ar_page_content_5;
        $pageDataId->page_title_6 = $request->page_title_6;
        $pageDataId->ar_page_title_6 = $request->ar_page_title_6;
        $pageDataId->page_content_6 = $request->page_content_6;
        $pageDataId->ar_page_content_6 = $request->ar_page_content_6;


        $pageDataId->ar_page_content_2 = $request->arabic_page_content_2;
        
       
     
    	if ($request->hasFile('page_banner_image'))
            {
                if ($request->file('page_banner_image')->isValid()) 
                    {
                        $validator = Validator::make($request->all(), [   
                            'page_banner_image' => 'required|mimes:png,jpg,jpeg|max:1024',
                        ]);
                        if($validator->fails())
                        {
                            return redirect()->back()->withErrors($validator->errors())->withInput();
                        }
                        $catimage = Mst_page_data::where('page_data_id','=',$getId)->first();
                        $proimg=$catimage->page_banner_image;   
                            
                                if($proimg!="")
	                                    {
	                                    	$path =  "assets/uploads/banner/".$proimg;

	                                    	if(file_exists($path))
	                                    	{
	                                    		unlink('assets/uploads/banner/'.$proimg);
	                                    	}
	                                    }
                                    
                                    $photo=$request->file('page_banner_image');
                                    $certLogoImage = time() . '.' . $photo->getClientOriginalExtension();
                                    $destinationPath = 'assets/uploads/banner';
                                    $thumb_img = Image::make($photo->getRealPath());
                                    $thumb_img->save($destinationPath . '/' .$certLogoImage);
                                     Mst_page_data::where('page_data_id','=',$getId)->update([

                                     		'page_banner_image' => $certLogoImage
                                     ]);

                    }
            }

            if ($request->hasFile('page_content_image'))
            {
                if ($request->file('page_content_image')->isValid()) 
                    {
                        $catimagecontent = Mst_page_data::where('page_data_id','=',$getId)->first();
                        $proimgContent=$catimagecontent->page_content_image;   
                            
                                if($proimgContent!="")
	                                    {
	                                    	$path =  "assets/uploads/page-data/".$proimgContent;

	                                    	if(file_exists($path))
	                                    	{
	                                    		unlink('assets/uploads/page-data/'.$proimgContent);
	                                    	}
	                                    }
                                    
                                    $photoContent=$request->file('page_content_image');
                                    $certLogoImageContent = time() . '.' . $photoContent->getClientOriginalExtension();
                                    $destinationPathContent = 'assets/uploads/page-data';
                                    $thumb_imgContent = Image::make($photoContent->getRealPath());
                                    $thumb_imgContent->save($destinationPathContent . '/' .$certLogoImageContent);
                                     Mst_page_data::where('page_data_id','=',$getId)->update([

                                     		'page_content_image' => $certLogoImageContent
                                     ]);

                    }
            }
        $pageDataId->update();
        $lang_file_en = file_get_contents(resource_path('lang/'.'en'.'.json'));
        $lang_file_ar = file_get_contents(resource_path('lang/'.'ar'.'.json'));
        $fen=json_decode($lang_file_en,true);
        $far=json_decode($lang_file_ar,true);
        $data_ar = [
            $pageDataId->page_title =>  $pageDataId->ar_page_name,
            $pageDataId->page_content   => $pageDataId->ar_page_content,
            $pageDataId->page_content_2 => $pageDataId->ar_page_content_2,
            $pageDataId->page_banner_title = $pageDataId->arabic_page_banner_title,
            $pageDataId->page_banner_description =$pageDataId->arabic_page_banner_description,
            $pageDataId->page_title_2 =>  $pageDataId->ar_page_title_2,
            $pageDataId->page_content_2   => $pageDataId->ar_page_content_2,
            $pageDataId->page_title_3 =>  $pageDataId->ar_page_title_3,
            $pageDataId->page_content_3   => $pageDataId->ar_page_content_3,
            $pageDataId->page_title_4 =>  $pageDataId->ar_page_title_4,
            $pageDataId->page_content_4   => $pageDataId->ar_page_content_4,
            $pageDataId->page_title_5 =>  $pageDataId->ar_page_title_5,
            $pageDataId->page_content_5   => $pageDataId->ar_page_content_5,
            $pageDataId->page_title_6 =>  $pageDataId->ar_page_title_6,
            $pageDataId->page_content_6   => $pageDataId->ar_page_content_6
           ];

        $data_en = [
            $pageDataId->page_content = $pageDataId->page_content,
            $pageDataId->page_title =   $pageDataId->page_title,
            $pageDataId->page_content_2 = $pageDataId->page_content_2 ,
            $pageDataId->page_banner_title = $pageDataId->page_banner_title ,
            $pageDataId->page_banner_description = $pageDataId->page_banner_description 
             ];

        $result_en = array_merge($fen,$data_en);
        $result_ar = array_merge($far,$data_ar);
        file_put_contents(resource_path('lang/'.'en'.'.json'),json_encode($result_en,JSON_PRETTY_PRINT));
        file_put_contents(resource_path('lang/'.'ar'.'.json'),json_encode($result_ar,JSON_PRETTY_PRINT));
       
        return redirect()->back()->with('status','Content Updated');
    }

    
    public function listProcess()
    {
    	$pageTitle = "Process and Packages";
    	$fetchDetail = Mst_page_data::where('page_name','=','process-and-package')->first();
    	return view('admin.elements.site-settings.process-and-package',compact('fetchDetail','pageTitle'));
    }

    
    public function listRequirements()
    {
    	$pageTitle = "Requirements";
    	$fetchDetail = Mst_page_data::where('page_name','=','requirements')->first();
    	return view('admin.elements.site-settings.requirements',compact('fetchDetail','pageTitle'));
    }

    public function listSaleCars()
    {
    	$pageTitle = "Car for sale";
    	$fetchDetail = Mst_page_data::where('page_name','=','car-for-sale')->first();
    	return view('admin.elements.site-settings.car-for-sale',compact('fetchDetail','pageTitle'));
    }

    public function listTermReNTALS()
    {
        $pageTitle = "Long term Rental";
        $fetchDetail = Mst_page_data::where('page_name','=','long-term-car-rental')->first();
        return view('admin.elements.site-settings.long-term-rental',compact('fetchDetail','pageTitle'));
    }
    public function shortTermRentel()
    {
        $pageTitle = "Short term Rental";
        $fetchDetail = Mst_page_data::where('page_name','=','short-term-car-rental')->first();
        return view('admin.elements.site-settings.short-term-rental',compact('fetchDetail','pageTitle'));
    }

    public function listLease()
    {
        $pageTitle = "Lease to Own";
        $fetchDetail = Mst_page_data::where('page_name','=','lease-to-own')->first();
        return view('admin.elements.site-settings.lease-to-own',compact('fetchDetail','pageTitle'));
    }

    public function listSocialIcons(Request $request)
    {
        $pageTitle = "Social Media Icons";
        $fetchDetail = Mst_social_media_icon::orderBy('icon_id','DESC')->get();
        return view('admin.elements.social-media.list',compact('fetchDetail','pageTitle'));
    }

    public function updateSocialIcons(Request $request)
    {
        $iconId = $request->icon_id;
        $socialMedia = Mst_social_media_icon::Find($iconId);
        $socialMedia->icon_name = $request->icon_name;
        $socialMedia->icon_link = $request->icon_link;
        $socialMedia->icon_fa   = $request->icon_fa;
        $socialMedia->update();
        return back()->with('status','Link Updated Successfully');
    }

    public function fetchChooseUs()
    {
        try{
        $pageTitle = "Why Choose Us";
        $fetchDetail = Mst_page_data::where('page_data_id','=',11)->first();
      
        return view('admin.elements.settings.why-choose-us',compact('fetchDetail','pageTitle'));
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
