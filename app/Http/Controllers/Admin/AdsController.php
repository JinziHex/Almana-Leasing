<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MstAds;
use Exception;
use Illuminate\Http\Request;
use Image;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.elements.ads.index', [
            'pageTitle' => "Ads",
            'ads' => MstAds::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.elements.ads.create', [
            'pageTitle' => "ads",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
            'is_active' => 'required'
        ], [
            'title.required' => "Title is required",
            'image.required' => "Image is required",
            'redirect_url.required' => "Redirect url is required",
            'is_active.required' => "Status is required",
        ]);

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $storyimagename = time() . '.' . $photo->getClientOriginalExtension();
            $destinationPath = 'assets/uploads/ads';
            $thumb_img = Image::make($photo->getRealPath());
            $thumb_img->save($destinationPath . '/' . $storyimagename, 80);
        }

        try {
            MstAds::create([
                'title' => $request->title,
                'image' => $storyimagename ?? '',
                // 'redirect_url' => $request->redirect_url,
                'is_active' => $request->is_active
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('admin.ads.index')->with('status', 'Ads created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad = MstAds::findOrFail($id);
        return view('admin.elements.ads.edit', [
            'pageTitle' => "Ads",
            'ad' => $ad
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ad = MstAds::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'is_active' => 'required'
        ], [
            'title.required' => "Title is required",
            'redirect_url.required' => "Redirect url is required",
            'is_active.required' => "Status is required",
        ]);

        if ($request->hasFile('image')) {

            //delete old file
            try {
            unlink('public/assets/uploads/ads/' . $ad->image);
            } catch (Exception $e) {}

            $photo = $request->file('image');
            $storyimagename = time() . '.' . $photo->getClientOriginalExtension();
            $destinationPath = 'assets/uploads/ads';
            $thumb_img = Image::make($photo->getRealPath());
            $thumb_img->save($destinationPath . '/' . $storyimagename, 80);
        }

        try {
            $ad->title = $request->title;
            // $ad->redirect_url = $request->redirect_url;
            $ad->is_active = $request->is_active;
            $ad->image =  $storyimagename ?? $ad->image;
            $ad->save();
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('admin.ads.index')->with('status', 'Ads updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ad = MstAds::findOrFail($id);

        try {
            if ($ad->image) {
                 try {
            unlink('public/assets/uploads/ads/' . $ad->image);
            } catch (Exception $e) {}
            }
            $ad->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Something went wrong');
        }
        return redirect()->route('admin.ads.index')->with('status', 'Ads deleted');
    }
}
