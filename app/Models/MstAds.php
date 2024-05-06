<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstAds extends Model
{
    protected $fillable = ['title', 'image', 'redirect_url', 'is_active'];
}
