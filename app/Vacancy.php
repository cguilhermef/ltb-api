<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
