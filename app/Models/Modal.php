<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    protected $primaryKey = "modal_id";
    protected $fillable = ['modal_id','model_number','modal_name','modal_category','makers','group_id','active_flag','rdy_count','created_at','updated_at'];

    public function category()
    {
    	return $this->belongsTo('App\Models\Model_category','modal_category','model_cat_id');
    }
    
    public function groups()
    {
    	return $this->belongsTo('App\Models\Model_group','group_id','group_id');
    }

    public function maker()
    {
    	return $this->belongsTo('App\Models\Maker','makers','maker_id');
    }
     public function rates()
    {
        return $this->hasMany('App\Models\Mode_rate','model_id',',modal_id');
    }

     public function specification()
    {
        return $this->belongsToMany('App\Models\Model_specification','model_id',',spec_id');
    }
     public function getSpec()
    {
        return $this->belongsTo('App\Models\Model_specification','modal_id','model_id');
    }
    
     public function modelImage()
    {
        return $this->belongsTo('App\Models\Model_image','modal_id','model_id');
    }

     public function images()
    {
        return $this->hasMany('App\Models\Model_image','model_id','modal_id');
    }

}
