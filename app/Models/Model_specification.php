<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model_specification extends Model
{
    protected $primaryKey = "model_spec_id";
    protected $fillable = ['model_spec_id','model_id','spec_id','is_active','created_at','updated_at'];

    public function carmodel()
    {
    	return $this->belongsTo('App\Models\Modal','model_id','modal_id');
    }

    public function specs()
    {
    	return $this->belongsTo('App\Models\Specification','spec_id','spec_id');
    }
}
