<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable =[
        'name'
    ];
    public function teams() {
        return $this->hasMany(Team::class);
    }

    public function profiles() {
        return $this->hasMany(Profile::class);
    }
}
