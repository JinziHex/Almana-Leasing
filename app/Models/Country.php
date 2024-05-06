<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'country_id';

    protected $fillable=['country_id','iso','country_name','nice_name','iso3','numcode','phonecode','created_at','updated_at'];
}
