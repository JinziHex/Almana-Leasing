<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $primaryKey = "status_id";

    protected $fillable=['status_id','status','created_at','updated_at'];
}
