<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_page_data extends Model
{
    protected $table="mst_page_datas";
    protected $primaryKey = "page_data_id";
    protected $fillable=['page_data_id','page_name','page_banner_title','page_banner_description','page_banner_image','page_title','page_content','page_content_2','page_content_image','created_at','updated_at'];
}
