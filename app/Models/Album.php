<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['title', 'photo'];

    public function photos()
    {
        return $this->hasMany('\App\Models\Photo');
    }
}
