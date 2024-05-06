<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City_location extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'city_loc_id';

    protected $fillable=['city_loc_id','city_id','location_name','created_at','updated_at'];

    public function citys()
    {
    	return $this->belongsTo('App\Models\City','city_id','city_id');
    }
}
