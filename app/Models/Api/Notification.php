<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table="notifications";
    protected $primaryKey = "notification_id";

    protected $fillable=['notification_id','customer_id','notification_title','notification_content','notification_status','created_at','updated_at'];

    public function customers()
    {
    	return $this->belongsTo('App\Models\Customer','customer_id','customer_id');
    }
}
