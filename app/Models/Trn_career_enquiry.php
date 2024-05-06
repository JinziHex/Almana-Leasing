<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trn_career_enquiry extends Model
{
    protected $table="trn_career_enquiries";
    protected $primaryKey = "career_enquiry_id";
    protected $fillable=['career_enquiry_id','career_id','enquiry_name','enquiry_email','enquiry_phone','enquiry_location','enquiry_message','enquiry_cv','created_at','updated_at'];

    public function careers()
    {
    	return $this->belongsTo('App\Models\Mst_career','career_id','career_id');
    }
}
