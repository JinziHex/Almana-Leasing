<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sys_job_category extends Model
{
    protected $table="sys_job_categories";
    protected $primaryKey = "job_category_id";
    protected $fillable=['job_category_id','category_title','category_title_slug','created_at','updated_at'];

    public function Catcareers()
    {
    	return $this->hasMany('App\Models\Mst_career','job_category_id');
    }
}
