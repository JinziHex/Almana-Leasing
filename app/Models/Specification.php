<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specification extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = "spec_id";
    protected $fillable = ['spec_id','spec_name','spec_icon','active_flag','created_at','updated_at'];
}
