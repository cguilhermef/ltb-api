<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summoner extends Model
{
    protected $fillable = [
        'id',
        'profile_icon_id',
        'name',
        'level',
        'revision_date',
        'summoner_id',
        'account_id',
        'tier_id'
    ];
}
