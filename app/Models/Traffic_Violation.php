<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traffic_Violation extends Model
{
    protected $primaryKey ="violation_id";

    protected $fillable=['violation_id','customer_id','model_id','violation_content','violation_date','created_at','updated_at'];

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer','customer_id','customer_id');
    }

    public function model()
    {
    	return $this->belongsTo('App\Models\Modal','model_id','modal_id');
    }
}
