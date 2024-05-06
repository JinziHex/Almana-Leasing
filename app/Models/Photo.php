<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['album_id', 'photo_title', 'photo_image'];

    public function album()
    {
        return $this->belongsTo('\App\Models\Album');
    }
}
