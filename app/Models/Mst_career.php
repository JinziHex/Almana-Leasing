<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_career extends Model
{
    protected $table="mst_careers";
    protected $primaryKey = "career_id";
    protected $fillable=['career_id','career_title','career_title_slug','job_category_id','job_location','job_company_name','job_salary_range','job_type_id','job_description','job_icon','job_status','created_at','updated_at'];

    public function jobCats()
    {
    	return $this->belongsTo('App\Models\Sys_job_category','job_category_id','job_category_id');
    }

    public function jobTypes()
    {
    	return $this->belongsTo('App\Models\Sys_job_type','job_type_id','job_type_id');
    }

    public function jobLocation()
    {
    	return $this->belongsTo('App\Models\City','job_location','city_id');
    }
}
