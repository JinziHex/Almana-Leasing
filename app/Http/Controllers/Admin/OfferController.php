<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mst_offer;
use App\Models\Mst_page_data;
use Validator;
use Crypt;
use Auth;
use Image;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listOffers(Request $request)
    {
    	$pageTitle = "All Offers";
    	$fetchDetail = Mst_offer::orderBy('offer_id','DESC')->get();
    	return view('admin.elements.offer.list',compact('fetchDetail','pageTitle'));
    }

    public function addOffers()
    {
    	$pageTitle = "Add New Offer";
    	return view('admin.elements.offer.add',compact('pageTitle'));
    }
    
    public function saveOffer(Request $request, Mst_offer $offers)
    {
    	$validator = Validator::make($request->all(), [   
                'offer_title' => 'required',
                'offer_image' => 'required|mimes:png,jpg,jpeg',
                
        ]);
        if(!$validator->fails())
            {
            	$offers->offer_title = $request->offer_title;
            	
            	if ($request->hasFile('offer_image'))
                    {
                                $photo = $request->file('offer_image'); 
                                $storyimagename = time() . '.' . $photo->getClientOriginalExtension();
                                $destinationPath = 'assets/uploads/offers';
                                $thumb_img = Image::make($photo->getRealPath());
                                $thumb_img->save($destinationPath . '/' .$storyimagename);
                                $offers->offer_image = $storyimagename;
                    }
                $offers->save();
                return redirect('admin/offers')->with('status','Added new Offer.');
            }else{
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
    }

    
    public function editOffer($id, Request $request)
    {
        $decrId = Crypt::decryptString($id);
        $pageTitle = "Edit Offer";
        $fetchDetail = Mst_offer::where('offer_id','=',$decrId)->first();
        return view('admin.elements.offer.edit',compact('pageTitle','fetchDetail'));
    }

    public function updateOffer(Request $request)
    {
        $getId = $request->offer_id;
        $mstOffer = Mst_offer::Find($getId);

                $mstOffer->offer_title = $request->offer_title;
               

                if ($request->hasFile('offer_image'))
                {
	                if ($request->file('offer_image')->isValid()) 
	                    {
	                        $catimage = Mst_offer::where('offer_id','=',$getId)->first();
	                        $proimg=$catimage->offer_image;   
	                            
	                                if($proimg!="")
	                                    {
	                                        unlink('assets/uploads/offers/'.$proimg);
	                                    }
	                                    
	                                    $photo=$request->file('offer_image');
	                                    $certLogoImage = time() . '.' . $photo->getClientOriginalExtension();
	                                    $destinationPath = 'assets/uploads/offers';
	                                    $thumb_img = Image::make($photo->getRealPath());
	                                    $thumb_img->save($destinationPath . '/' .$certLogoImage);
	                                    $mstOffer->offer_image = $certLogoImage; 

	                    }
            	}

            	
        $mstOffer->update();
        return redirect('admin/offers')->with('status','Offer Updated');
    }

    
    public function deleteOffer($id)
    {
        $decrId = Crypt::decryptString($id);
        $fetchContent = Mst_offer::Find($decrId);
        $offerImg = $fetchContent->offer_image;
       
        if($offerImg!="")
            {
                unlink('assets/uploads/offers/'.$offerImg);
            }
       
        Mst_offer::where('offer_id','=',$decrId)->delete();
        return back()->with('status','Offer Deleted');
    }
    
    public function fetchBanner()
    {
        $fetchDetail = Mst_page_data::where('page_name','=','offer')->first();
        $pageTitle = "Offers Banner";
        return view('admin.elements.offer.banner',compact('pageTitle','fetchDetail'));

    }

}
