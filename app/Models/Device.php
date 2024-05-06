<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table="devices";

    protected $primaryKey = "device_id";

    protected $fillable = ['device_id','customer_id','device_type','device_token','created_at','updated_at','expires_at'];
}
