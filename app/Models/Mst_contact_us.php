<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_contact_us extends Model
{
    protected $table="mst_contact_us";
    protected $primaryKey = "contact_id";
    protected $fillable=['contact_id','contact_page_heading','contact_page_meta_description','contact_phone_number_1','contact_phone_number_2','contact_mail_1','contact_mail_2','contact_address','contact_address_map_embed_url','contact_banner_image','created_at','updated_at'];
}
