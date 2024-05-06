<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment_status extends Model
{
    protected $primaryKey = "payment_id";
    protected $fillable = ['payment_id','payment_status','created_at','updated_at'];
}
