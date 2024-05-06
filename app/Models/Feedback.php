<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $primaryKey ="feedback_id";
    
    public $table="feedback";

    protected $fillable=['feedback_id','feedback_type','customer_id','feedback_message','feedback_fname','feedback_lname','feedback_email','post_date','created_at','updated_at'];

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer','customer_id','customer_id');
    }

    protected $casts = [
    'post_date' => 'datetime:Y-m-d-H:i:s',
    ];

}
