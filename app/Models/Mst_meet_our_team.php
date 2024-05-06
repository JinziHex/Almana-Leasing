<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mst_meet_our_team extends Model
{
    protected $table="mst_meet_our_teams";
    protected $primaryKey = "team_id";
    protected $fillable=['team_id','team_member_name','team_member_image','team_member_designation','created_at','updated_at'];
}
