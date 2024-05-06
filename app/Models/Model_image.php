<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model_image extends Model
{
    protected $primaryKey = "model_image_id";
    protected $fillable = ['model_image_id','model_id','model_image','model_image_flag','created_at','updated_at'];

    public function carmodel()
    {
    	return $this->belongsTo('App\Models\Modal','model_id','modal_id');
    }
}
