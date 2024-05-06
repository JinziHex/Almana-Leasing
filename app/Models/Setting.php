<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table="settings";
    protected $fillable=['id','st_title','st_description','st_description_line_2','created_at','updated_at'];
}
