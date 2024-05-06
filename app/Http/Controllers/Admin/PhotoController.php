<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Image;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.elements.album.photo.index', [
            'pageTitle' => "Photos",
            'photos' => Photo::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.elements.album.photo.create', [
            'pageTitle' => "Photos",
            'albums' => Album::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Photo $photo)
    {
        $request->validate([
            'album_id' => 'required',
            'title' => 'required',
            'photo' => 'required'
        ], [
            'album_id.required' => "Album is required",
            'title.required' => "Title is required",
            'photo.required' => "Photo is required",
        ]);

        try {
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $storyimagename = time() . '.' . $photo->getClientOriginalExtension();
                $destinationPath = 'assets/uploads/album/photo';
                $thumb_img = Image::make($photo->getRealPath());
                $thumb_img->save($destinationPath . '/' . $storyimagename, 80);
            }

            Photo::create([
                'album_id' => $request->album_id,
                'photo_title' => $request->title,
                'photo_image' => $storyimagename ?? ''
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('admin.photos.index')->with('status', 'New photo added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        return view('admin.elements.album.photo.edit', [
            'pageTitle' => "Photos",
            'albums' => Album::get(),
            'photo' => $photo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'album_id' => 'required',
            'title' => 'required',
        ], [
            'album_id.required' => 'Album is required',
            'title.required' => "Title is required",
        ]);

        try {

            $photo->album_id = $request->album_id;
            $photo->photo_title = $request->title;

            if ($request->hasFile('photo')) {
                //delete old file
                try {
                  unlink('assets/uploads/album/photo/' . $photo->photo_image);
                } catch (Exception $e) {}
                //store new file
                $image = $request->file('photo');
                $storyimagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = 'assets/uploads/album/photo/';
                $thumb_img = Image::make($image->getRealPath());
                $thumb_img->save($destinationPath . '/' . $storyimagename, 80);
            }

            $photo->photo_image =  $storyimagename ?? $photo->photo_image;
            $photo->save();
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('admin.photos.index')->with('status', 'Photo updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        try {
            if ($photo->photo_image) {
                 try {
                    unlink('assets/uploads/album/photo/' . $photo->photo_image);
                } catch (Exception $e) {}
            }

            $photo->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Something went wrong');
        }
        return redirect()->route('admin.photos.index')->with('status', 'Photo deleted');
    }
}
