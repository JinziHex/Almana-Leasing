<?php

namespace App\Http\Controllers\Admin;

use App\Models\Album;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Image;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.elements.album.index', [
            'pageTitle' => "Albums",
            'albums' => Album::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.elements.album.create', [
            'pageTitle' => "Albums",
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
        ], [
            'title.required' => "Title is required",
        ]);

        // if ($request->hasFile('photo')) {
        //     $photo = $request->file('photo');
        //     $storyimagename = time() . '.' . $photo->getClientOriginalExtension();
        //     $destinationPath = 'assets/uploads/album';
        //     $thumb_img = Image::make($photo->getRealPath());
        //     $thumb_img->save($destinationPath . '/' . $storyimagename, 80);
        // }

        try {
            Album::create([
                'title' => $request->title,
                // 'photo' => $storyimagename ?? ''
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('admin.albums.index')->with('status', 'Added new Album');
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
    public function edit(Album $album)
    {
        return view('admin.elements.album.edit', [
            'pageTitle' => "Albums",
            'album' => $album
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => "Title is required",
        ]);

        // if ($request->hasFile('photo')) {

        //     //delete old file
        //      try {
        //             unlink('assets/uploads/album/' . $album->photo);
        //         } catch (Exception $e) {}

        //     $photo = $request->file('photo');
        //     $storyimagename = time() . '.' . $photo->getClientOriginalExtension();
        //     $destinationPath = 'assets/uploads/album';
        //     $thumb_img = Image::make($photo->getRealPath());
        //     $thumb_img->save($destinationPath . '/' . $storyimagename, 80);
        // }

        try {
            $album->title = $request->title;
            // $album->photo =  $storyimagename ?? $album->photo;
            $album->save();
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('admin.albums.index')->with('status', 'Album updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        try {
            if (!$album->photos->count()) {
                // if ($album->photo) {
                //      try {
                //     unlink('assets/uploads/album/' . $album->photo);
                // } catch (Exception $e) {}
                // }
                $album->delete();
            }else{
               return redirect()->back()->with('status', 'Unable to delete. Album has Photos');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Something went wrong');
        }
        return redirect()->route('admin.albums.index')->with('status', 'Album deleted');
    }
}
