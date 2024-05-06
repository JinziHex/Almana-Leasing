<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sys_job_type extends Model
{
    protected $table="sys_job_types";
    protected $primaryKey = "job_type_id";
    protected $fillable=['job_type_id','job_type_title','created_at','updated_at'];

    public function typeCareers()
    {
    	return $this->hasMany('App\Models\Mst_career','job_type_id');
    }
}
