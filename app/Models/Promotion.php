<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use SoftDeletes;
    protected $table="promotions";
    protected $primaryKey = "promotion_id";
    protected $fillable = ['promotion_id','modal_id','price','start_date','end_date','deleted_at'];
   

    public function modal()
    {
    	return $this->belongsTo('App\Models\Modal','modal_id','modal_id');
    }
}
