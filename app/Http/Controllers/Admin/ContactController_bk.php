<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mst_contact_us;
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
    	$pageTitle = "Contact Us";
    	$getId = $request->contact_id;
    	$Contactdetail = Mst_contact_us::Find($getId);

    	$Contactdetail->contact_page_heading = $request->contact_page_heading;
    	$Contactdetail->contact_page_meta_description = $request->contact_page_meta_description;
    	$Contactdetail->contact_phone_number_1 = $request->contact_phone_number_1;
    	$Contactdetail->contact_phone_number_2 = $request->contact_phone_number_2;
    	$Contactdetail->contact_mail_2 = $request->contact_mail_2;
    	$Contactdetail->contact_mail_1 = $request->contact_mail_1;
    	$Contactdetail->contact_address = $request->contact_address;
    	$Contactdetail->contact_address_map_embed_url = $request->contact_address_map_embed_url;

        if ($request->hasFile('contact_banner_image'))
            {

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
        $pageTitle = "Contact Enquiry List";
        $fetchEnquiryList = Trn_contact_enquiries::orderBy('contact_enquiry_id','DESC')->get();
        return view('admin.elements.contact.enquiry',compact('pageTitle','fetchEnquiryList'));
    }

    
    public function deleteEnquiry($id)
    {
        $decrId = Crypt::decryptString($id);
        Trn_contact_enquiries::where('contact_enquiry_id','=',$decrId)->delete();
        return back()->with('status','Enquiry Deleted');
    }
}
