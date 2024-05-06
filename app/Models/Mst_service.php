<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_service extends Model
{
    protected $table="mst_services";
    protected $primaryKey = "service_id";
    protected $fillable=['service_id','service_title','service_description','service_image_1','service_image_2','service_content_title','service_content_description','created_at','updated_at'];
}
