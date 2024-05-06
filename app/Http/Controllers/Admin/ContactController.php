<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mst_contact_us;
use App\Models\Mst_social_media_icon;
use App\Models\Trn_contact_enquiries;
use Validator;
use Crypt;
use Auth;
use Image;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getContactInfo(Request $request)
    {
    	$pageTitle = "Contact Us";
    	$fetchDetail = Mst_contact_us::where('contact_id','=',1)->first();
    	return view('admin.elements.contact.main',compact('fetchDetail','pageTitle'));
    }

    
    public function updateContactInfo(Request $request)
    {
        $request->validate([   
            'contact_mail_1' => 'required|email',
            'contact_phone_number_1'=>'required|min:8|regex:/^([0-9\s\-\+\(\)]*)$/',
            'se_land' => 'required|min:8|regex:/^([0-9\s\-\+\(\)]*)$/',
            'se_mob' => 'required|min:8|regex:/^([0-9\s\-\+\(\)]*)$/',
            'se_email1' => 'required|email',
            'se_email2' => 'required|email',
            'ch_land' => 'required|min:8|regex:/^([0-9\s\-\+\(\)]*)$/',
             'ch_mob' => 'required|min:8|regex:/^([0-9\s\-\+\(\)]*)$/',
            'ch_email' => 'required|email',
            'sm_land' => 'required|min:8|regex:/^([0-9\s\-\+\(\)]*)$/',
            'sm_mob' => 'required|min:8|regex:/^([0-9\s\-\+\(\)]*)$/',
            'sm_email' => 'required|email',
            'ab_land' => 'required|min:8|regex:/^([0-9\s\-\+\(\)]*)$/',
            'ab_mob' => 'required|min:8|regex:/^([0-9\s\-\+\(\)]*)$/',
            
           
        ],
        [
            'contact_phone_number_1.required'         => 'Contact number 1  required',
            'contact_phone_number_1.required.min'  =>  'Contact number 1- Minimum 8 digits required   ',
            'contact_phone_number_1.required.regex'  =>  'Contact number 1- Invalid format   ',
             'se_land.required'         => 'Service enquiry Landline  required',
            'se_land.required.min'  =>  'Service enquiry Landline- Minimum 8 digits required   ',
            'se_land.required.regex'  =>  'Service enquiry Landline- Invalid format   ',
             'se_mob.required'         => 'Service enquiry Mobile  required',
            'se_mob.required.min'  =>  'Service enquiry Mobile- Minimum 8 digits required   ',
            'se_mob.required.regex'  =>  'Service enquiry mobile- Invalid format   ',
            'ch_land.required'         => 'Chauffer Enquiry Landline  required',
            'ch_land.required.min'  =>  'Chauffer Enquiry Landline- Minimum 8 digits required   ',
            'ch_land.required.regex'  =>  'Chauffer Enquiry Landline- Invalid format   ',
            'ch_mob.required'         => 'Chauffer Enquiry Mobile  required',
            'ch_mob.required.min'  =>  'Chauffer Enquiry Mobile- Minimum 8 digits required   ',
            'ch_mob.required.regex'  =>  'Chauffer Enquiry mobile- Invalid format   ',
            'sm_land.required'         => 'Service/Maintanance Landline  required',
            'sm_land.required.min'  =>  'Service/Maintanance Landline- Minimum 8 digits required   ',
            'sm_land.required.regex'  =>  'Service/Maintanance Landline- Invalid format   ',
            'sm_mob.required'         => 'Service/Maintanance Mobile  required',
            'sm_mob.required.min'  =>  'Service/Maintanance Mobile- Minimum 8 digits required   ',
            'sm_mob.required.regex'  =>  'Service/Maintanance mobile- Invalid format   ',
            'ab_land.required'         => 'Airport Branch Landline  required',
            'ab_land.required.min'  =>  'Airport Branch Landline- Minimum 8 digits required   ',
            'ab_land.required.regex'  =>  'Airport Branch Landline- Invalid format   ',
            'ab_mob.required'         => 'Airport Branch Mobile  required',
            'ab_mob.required.min'  =>  'Airport Branch Mobile- Minimum 8 digits required   ',
            'ab_mob.required.regex'  =>  'Airport Branch mobile- Invalid format   ',
        ]
);

    	$pageTitle = "Contact Us";
    	$getId = $request->contact_id;
    	$Contactdetail = Mst_contact_us::Find($getId);

    	$Contactdetail->contact_page_heading = $request->contact_page_heading;
    	$Contactdetail->contact_page_meta_description = $request->contact_page_meta_description;
    	$Contactdetail->contact_phone_number_1 = $request->contact_phone_number_1;
    	$Contactdetail->contact_phone_number_2 = $request->contact_phone_number_2??'';
    	$Contactdetail->contact_mail_2 = $request->contact_mail_2??'';
    	$Contactdetail->contact_mail_1 = $request->contact_mail_1;
    	$Contactdetail->sales_enquiry_landline  = $request->se_land;
    	$Contactdetail->sales_enquiry_mobile  = $request->se_mob;
    	$Contactdetail->sales_enquiry_email1  = $request->se_email1;
    	$Contactdetail->sales_enquiry_email2  = $request->se_email2;
    	 
    	$Contactdetail->ch_service_enq_landline  = $request->ch_land;
    	$Contactdetail->ch_service_enq_mobile  = $request->ch_mob;
    	$Contactdetail->ch_service_enq_email  = $request->ch_email;
    	$Contactdetail->sm_landline  = $request->sm_land;
    	$Contactdetail->sm_mobile  = $request->sm_mob;
    	$Contactdetail->sm_email  = $request->sm_email;
    	$Contactdetail->ab_landline  = $request->ab_land;
    	$Contactdetail->ab_mobile  = $request->ab_mob;
    	$Contactdetail->fb_link  = $request->fb_link;
    	$Contactdetail->link_link  = $request->link_link;
    	$Contactdetail->you_link  = $request->you_link;
    	$Contactdetail->tw_link  = $request->tw_link;
    	$Contactdetail->contact_address = $request->contact_address;
    	$Contactdetail->contact_address_map_embed_url = $request->contact_address_map_embed_url;
    	
    	$fbicon=Mst_social_media_icon::findOrFail(2);
    	$fbicon->icon_link=$request->fb_link;
    	$fbicon->update();
    	
    	$twicon=Mst_social_media_icon::findOrFail(1);
    	$twicon->icon_link=$request->tw_link;
    	$twicon->update();
    	
    	$youicon=Mst_social_media_icon::findOrFail(3);
    	$youicon->icon_link=$request->you_link;
    	$youicon->update();
    	
    	$linicon=Mst_social_media_icon::findOrFail(4);
    	$linicon->icon_link=$request->link_link;
    	$linicon->update();
    	
    	$igicon=Mst_social_media_icon::findOrFail(5);
    	$igicon->icon_link=$request->ig_link;
    	$igicon->update();
    	

        if ($request->hasFile('contact_banner_image'))
            {
                
                $validator = Validator::make($request->all(), [   
                    'contact_banner_image' => 'required|mimes:png,jpg,jpeg|max:1024',
                ]);
            if($validator->fails())
                {
                    return redirect()->back()->withErrors($validator->errors())->withInput();
                }
                if ($request->file('contact_banner_image')->isValid()) 
                    {
                        $catimage = Mst_contact_us::where('contact_id','=',$getId)->first();
                        $proimg=$catimage->contact_banner_image;   


                                    if($proimg!="")
                                        {
                                            $path =  "assets/uploads/banner/".$proimg;

                                            if(file_exists($path))
                                            {
                                                unlink('assets/uploads/banner/'.$proimg);
                                            }
                                        }
                                    
                                    $photo=$request->file('contact_banner_image');
                                    $certLogoImage = time() . '.' . $photo->getClientOriginalExtension();
                                    $destinationPath = 'assets/uploads/banner';
                                    $thumb_img = Image::make($photo->getRealPath());
                                    $thumb_img->save($destinationPath . '/' .$certLogoImage);
                                    Mst_contact_us::where('contact_id','=',$getId)->update([
                                        'contact_banner_image' => $certLogoImage
                                    ]);

                    }
            }
            
        $Contactdetail->update();
        return redirect()->back()->with('status','Content Updated');
    }

    public function listEnquiry()
    {
        try
        {
            $pageTitle = "Contact Enquiry List";
        $fetchEnquiryList = Trn_contact_enquiries::orderBy('contact_enquiry_id','DESC')->get();
        return view('admin.elements.contact.enquiry',compact('pageTitle','fetchEnquiryList'));
        }
        catch (\Exception $e) {
                
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
       
     }catch (\Throwable $e) {
       
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

     }
    }

    
    public function deleteEnquiry($id)
    {
        try
        {
            $decrId = Crypt::decryptString($id);
        Trn_contact_enquiries::where('contact_enquiry_id','=',$decrId)->delete();
        return back()->with('status','Enquiry Deleted');
        }
        catch (\Exception $e) {
                
            return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);
       
     }catch (\Throwable $e) {
       
        return Redirect::back()->withErrors(['Something went wrong',$e->getMessage()]);

     }

    }
}
