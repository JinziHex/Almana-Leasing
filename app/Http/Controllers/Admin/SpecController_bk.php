<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        	$specDetail = Specification::orderBy('spec_id','DESC')->get();
        	return view('admin.elements.specification.index',compact('pageTitle','specDetail'));
        }else{
            return redirect('/login');
        }
    }
    public function add(Request $request)
    {
        if (Auth::check())
        {
        	$pageTitle = "Add Specification";
        	return view('admin.elements.specification.add',compact('pageTitle'));
        }else{
            return redirect('/login');
        }   
    }
    public function save(Request $request)
    {
    	$validator = Validator::make($request->all(), [   
            'spec_name' => 'required|unique:specifications', 
        ],
        [ 	'spec_name.unique' => "Specification name is already taken",
        	'spec_name.required' => "Specification name is required",

        ]);
        if(!$validator->fails())
        {
            $data= $request->except('_token');
            $currDetail = Specification::insertGetId($data);
            if ($request->hasFile('spec_icon'))
            {
                $photo = $request->file('spec_icon'); 

                        $storyimagename = time() . '.' . $photo->getClientOriginalExtension();

                        $destinationPath = 'assets/uploads/specifications/icons';
                        $thumb_img = Image::make($photo->getRealPath())->resize(50,50);
                        $thumb_img->save($destinationPath . '/' .$storyimagename, 80);

                        $resImgId = Specification::where('spec_id','=',$currDetail)->update([
                            'spec_icon'    =>  $storyimagename, 
                            'updated_at'  =>  \Carbon\Carbon::now(),
                        ]);
            }
                    
            return redirect('/admin/specification')->with('status','Specification added Successfully');
        }else{
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
    }

    public function edit($id, Request $request)
    {
        if (Auth::check())
        {
        	$specId = Crypt::decryptString($id);
        	$pageTitle = "Edit Specification";
        	$resUpdate = Specification::where('spec_id','=',$specId)->first();
        	return view('admin.elements.specification.edit',compact('pageTitle','specId','resUpdate'));
        }else{
            return redirect('/login');
        }
    }
    public function update(Request $request, Specification $specification)
    {
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
    	$specification->save();
    	return redirect('/admin/specification')->with('status','Specification Updated');
    }
    public function delete($id)
    {
    	$decryptId = Crypt::decryptString($id);
    	$checkExistnce = Model_specification::where('spec_id',$decryptId)->get();
    	if(!$checkExistnce->isEmpty())
    	{
    	    return back()->with('status','Unable to delete. Models Exists with this specification, Please unlink the models and try again.');
    	}else{
    	   	Model_specification::where('spec_id',$decryptId)->delete();
    	    Specification::where('spec_id',$decryptId)->delete();
    	    return back()->with('status','Deleted Specification');
    	    
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
