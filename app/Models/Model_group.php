<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model_group extends Model
{
    protected $table="model_group";
    protected $primaryKey = "group_id";
    protected $fillable = ['group_id','group_code','group_name','created_at','updated_at'];

   

}
