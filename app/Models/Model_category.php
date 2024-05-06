<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model_category extends Model
{
    protected $primaryKey = "model_cat_id";
    protected $fillable = ['model_cat_id','model_cat_name','active_flag','created_at','updated_at'];
    
    public function carModels()
    {
    	 return $this->hasMany('App\Models\Modal','modal_category');
    }
}
