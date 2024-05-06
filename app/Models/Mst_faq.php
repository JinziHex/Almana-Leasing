<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_faq extends Model
{
    protected $table="mst_faq";
    protected $primaryKey = "faq_id";
    protected $fillable=['faq_id','faq_question','faq_answer','created_at','updated_at'];
}
