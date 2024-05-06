<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    
    use SoftDeletes;
    
    protected $primaryKey = 'currency_id';

    protected $fillable=['currency_id','currency_code','currency_name','currency_conversion_rate','created_at','updated_at'];
    
}
