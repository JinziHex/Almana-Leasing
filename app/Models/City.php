<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'city_id';

    protected $fillable=['city_id','country_id','city_name','created_at','updated_at'];

    public function country()
    {
    	return $this->belongsTo('App\Models\Country','country_id','country_id');
    }

}
