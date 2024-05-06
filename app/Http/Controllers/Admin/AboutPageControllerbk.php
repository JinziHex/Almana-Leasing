<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mst_about_us;
use App\Models\Mst_meet_our_team;
use App\Models\Mst_clients;
use Validator;
use Crypt;
use Auth;
use Image;

class AboutPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listmainContent(Request $request)
    {
    	$pageTitle = "About Us";
    	$fetchDetail = Mst_about_us::where('about_content_id','=',1)->first();
    	return view('admin.elements.about.main-content',compact('fetchDetail','pageTitle'));
    }

    public function updateMainContent(Request $request)
    {
    	$pageTitle = "About Us";
    	$getId = $request->about_content_id;
    	$aboutUs = Mst_about_us::Find($getId);

    	$aboutUs->about_us_pagetitle = $request->about_us_pagetitle;
    	$aboutUs->about_page_meta_description = $request->about_page_meta_description;
    	$aboutUs->about_content_main_title = $request->about_content_main_title;
    	$aboutUs->about_content_description = $request->about_content_description;
    	if ($request->hasFile('about_page_banner_image'))
            {
                if ($request->file('about_page_banner_image')->isValid()) 
                    {
                        $catimage = Mst_about_us::where('about_content_id','=',$getId)->first();
                        $proimg=$catimage->about_page_banner_image;   


                                    if($proimg!="")
                                        {
                                            $path =  "assets/uploads/banner/".$proimg;

                                            if(file_exists($path))
                                            {
                                                unlink('assets/uploads/banner/'.$proimg);
                                            }
                                        }
                                    
                                    $photo=$request->file('about_page_banner_image');
                                    $certLogoImage = time() . '.' . $photo->getClientOriginalExtension();
                                    $destinationPath = 'assets/uploads/banner';
                                    $thumb_img = Image::make($photo->getRealPath());
                                    $thumb_img->save($destinationPath . '/' .$certLogoImage);
                                    $aboutUs->about_page_banner_image = $certLogoImage; 

                    }
            }
        $aboutUs->update();
        return redirect()->back()->with('status','Content Updated');
    }

    public function listTeams()
    {
        $pageTitle = "Meet our Team";
        $fetchDetail = Mst_meet_our_team::orderBy('team_id','DESC')->get();
        return view('admin.elements.about.team.list',compact('fetchDetail','pageTitle'));
    }

    public function addTeam()
    {
        $pageTitle = "Add new Member";
        return view('admin.elements.about.team.add',compact('pageTitle'));
    }

    public function saveTeam(Request $request,Mst_meet_our_team $our_team)
    {

        $validator = Validator::make($request->all(), [   
                'team_member_name' => 'required',
                'team_member_designation' => 'required',
                'team_member_image' => 'required|mimes:png,jpg,jpeg',
            ]);
        if(!$validator->fails())
            {
                $our_team->team_member_name = $request->team_member_name;
                $our_team->team_member_designation = $request->team_member_designation;
                if ($request->hasFile('team_member_image'))
                    {
                                $photo = $request->file('team_member_image'); 
                                $storyimagename = time() . '.' . $photo->getClientOriginalExtension();
                                $destinationPath = 'assets/uploads/team';
                                $thumb_img = Image::make($photo->getRealPath());
                                $thumb_img->save($destinationPath . '/' .$storyimagename, 80);
                                $our_team->team_member_image = $storyimagename;
                    }
                $our_team->save();
                return redirect('admin/about-us/teams')->with('status','Member created.');
            }else{
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }


    }

    
    public function editTeam($id, Request $request)
    {
        $decrId = Crypt::decryptString($id);
        $pageTitle = "Edit Member";
        $fetchDetail = Mst_meet_our_team::where('team_id','=',$decrId)->first();
        return view('admin.elements.about.team.edit',compact('pageTitle','fetchDetail'));
    }

    public function updateTeam(Request $request)
    {
        $getId = $request->team_id;
        $mstTeam = Mst_meet_our_team::Find($getId);
                $mstTeam->team_member_name = $request->team_member_name;
                $mstTeam->team_member_designation = $request->team_member_designation;
                if ($request->hasFile('team_member_image'))
                {
                if ($request->file('team_member_image')->isValid()) 
                    {
                        $catimage = Mst_meet_our_team::where('team_id','=',$getId)->first();
                        $proimg=$catimage->team_member_image;   

                                    if($proimg!="")
                                        {
                                            $path =  "assets/uploads/team/".$proimg;

                                            if(file_exists($path))
                                            {
                                                unlink('assets/uploads/team/'.$proimg);
                                            }
                                        }
                                    
                                    $photo=$request->file('team_member_image');
                                    $certLogoImage = time() . '.' . $photo->getClientOriginalExtension();
                                    $destinationPath = 'assets/uploads/team';
                                    $thumb_img = Image::make($photo->getRealPath());
                                    $thumb_img->save($destinationPath . '/' .$certLogoImage);
                                    $mstTeam->team_member_image = $certLogoImage; 

                    }
            }
        $mstTeam->update();
         return redirect('admin/about-us/teams')->with('status','Content Updated');
    }

    
    public function deleteTeam($id)
    {
        $decrId = Crypt::decryptString($id);
        $fetchContent = Mst_meet_our_team::Find($decrId);
        $teamImg = $fetchContent->team_member_image;
        if($teamImg!="")
            {
                $path =  "assets/uploads/team/".$teamImg;

                if(file_exists($path))
                    {
                        unlink('assets/uploads/team/'.$teamImg);
                    }
            }
        Mst_meet_our_team::where('team_id','=',$decrId)->delete();
        return back()->with('status','Member Deleted');
    }

    public function listClients(Request $request)
    {
        $pageTitle = "Clients";
        $fetchDetail = Mst_clients::orderBy('client_id','DESC')->get();
        return view('admin.elements.about.client.list',compact('pageTitle','fetchDetail'));

    }

    public function addClients()
    {
        $pageTitle = "Add New Client";
        return view('admin.elements.about.client.add',compact('pageTitle'));
    }

    public function saveClient(Request $request, Mst_clients $clients)
    {
         $validator = Validator::make($request->all(), [   
                'client_name' => 'required',
                'client_logo' => 'required|mimes:png,jpg,jpeg',
            ]);
        if(!$validator->fails())
            {
                $clients->client_name = $request->client_name;
                if ($request->hasFile('client_logo'))
                    {
                                $photo = $request->file('client_logo'); 
                                $storyimagename = time() . '.' . $photo->getClientOriginalExtension();
                                $destinationPath = 'assets/uploads/client';
                                $thumb_img = Image::make($photo->getRealPath());
                                $thumb_img->save($destinationPath . '/' .$storyimagename, 80);
                                $clients->client_logo = $storyimagename;
                    }
                $clients->save();
                return redirect('admin/about-us/clients')->with('status','Client Added');

            }else{
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

    }

    
    public function editClient($id, Request $request)
    {
        $decrId = Crypt::decryptString($id);
        $pageTitle = "Edit Client";
        $fetchDetail = Mst_clients::where('client_id','=',$decrId)->first();
        return view('admin.elements.about.client.edit',compact('pageTitle','fetchDetail'));
    }

    
    public function updateClient(Request $request)
    {
        $getId = $request->client_id;
        $mstClient = Mst_clients::Find($getId);
                $mstClient->client_name = $request->client_name;
               
                if ($request->hasFile('client_logo'))
                {
                if ($request->file('client_logo')->isValid()) 
                    {
                        $catimage = Mst_clients::where('client_id','=',$getId)->first();
                        $proimg=$catimage->client_logo;   

                                    if($proimg!="")
                                        {
                                            $path =  "assets/uploads/client/".$proimg;

                                            if(file_exists($path))
                                            {
                                                unlink('assets/uploads/client/'.$proimg);
                                            }
                                        }
                                    
                                    $photo=$request->file('client_logo');
                                    $certLogoImage = time() . '.' . $photo->getClientOriginalExtension();
                                    $destinationPath = 'assets/uploads/client';
                                    $thumb_img = Image::make($photo->getRealPath());
                                    $thumb_img->save($destinationPath . '/' .$certLogoImage);
                                    $mstClient->client_logo = $certLogoImage; 

                    }
            }
        $mstClient->update();
         return redirect('admin/about-us/clients')->with('status','Content Updated');
    }

    public function deleteClient($id)
    {
        $decrId = Crypt::decryptString($id);
        $fetchContent = Mst_clients::Find($decrId);
        $clientImg = $fetchContent->client_logo;

        if($clientImg!="")
            {
                $path =  "assets/uploads/client/".$clientImg;

                    if(file_exists($path))
                        {
                            unlink('assets/uploads/client/'.$clientImg);
                    }
            }
       
        Mst_clients::where('client_id','=',$decrId)->delete();
        return back()->with('status','Client Deleted');
    
    }



}
