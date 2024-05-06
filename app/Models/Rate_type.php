<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate_type extends Model
{
    protected $primaryKey =  "rate_type_id";

    protected $fillable=['rate_type_id','rate_type_code','rate_type_name','rate_type_days','rate_type_status','created_at','updated_at'];
}
