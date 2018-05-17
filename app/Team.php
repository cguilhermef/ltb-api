<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'region_id'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function region() {
        return $this->belongsTo(Region::class);
    }
}
