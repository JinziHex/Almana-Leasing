<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_clients extends Model
{
    protected $table="mst_clients";
    protected $primaryKey = "client_id";
    protected $fillable=['client_id','client_name','client_logo','created_at','updated_at'];
}
