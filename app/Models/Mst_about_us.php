<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_about_us extends Model
{
    protected $table="mst_about_us";
    protected $primaryKey = "about_content_id";
    protected $fillable=['about_content_id','about_us_pagetitle','about_page_meta_description','about_content_main_title','about_content_description','about_content_meet_team_title','about_content_meet_team_description','about_content_type','about_page_banner_image','created_at','updated_at'];
    
}
