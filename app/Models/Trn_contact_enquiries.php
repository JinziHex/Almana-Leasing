<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trn_contact_enquiries extends Model
{
    protected $table="trn_contact_enquiries";
    protected $primaryKey = "contact_enquiry_id";
    protected $fillable=['contact_enquiry_id','contact_enquiry_fname','contact_enquiry_lname','contact_enquiry_email_address','contact_enquiry_phone','contact_enquiry_message','created_at','updated_at'];


}
