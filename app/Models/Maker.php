<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maker extends Model
{
    protected $primaryKey = "maker_id";
    protected $fillable = ['maker_id','maker_name','created_at','updated_at'];
}
