<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mode_rate extends Model
{
    protected $primaryKey =  "model_rate_id";

    protected $fillable=['model_rate_id','model_id','maker_id','model_year','rate_type_id','rate_code','rate','model_min_rate','modal_chauff_rate','modal_cfmin_rate','created_at','updated_at'];

    public function rates()
    {
    	return $this->belongsTo('App\Models\Rate_type','rate_type_id','rate_type_id');
    }
    
    public function makers()
    {
    	return $this->belongsTo('App\Models\Maker','maker_id','maker_id');
    }


    public function models()
    {
    	return $this->belongsTo('App\Models\Modal','model_id','model_number');
    }
}
