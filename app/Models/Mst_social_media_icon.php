<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_social_media_icon extends Model
{
    protected $table="mst_social_media_icons";
    protected $primaryKey = "icon_id";
    protected $fillable=['icon_id','icon_name','icon_link','icon_fa','created_at','updated_at'];
}
