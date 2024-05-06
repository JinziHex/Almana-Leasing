<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_offer extends Model
{
    protected $table="mst_offers";
    protected $primaryKey = "offer_id";
    protected $fillable=['offer_id','offer_title','offer_image','created_at','updated_at'];
}
