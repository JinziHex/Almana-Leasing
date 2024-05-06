<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Photo;




class GalleryController extends Controller
{
  
    public function albums()
    {
        $pageTitle = "Al Mana Leasing Photo Gallery";
        $pageDescription = "Browse our gallery for a closer look at the premium vehicles available for rent and lease at Al Mana Leasing.";

        return view('front-end.elements.gallery.album',[
            'albums' => Album::get(),
            'pageTitle' => $pageTitle,
            'pageDescription' =>$pageDescription
        ]);
    }
}