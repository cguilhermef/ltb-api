<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Map;

class Mode extends Model
{
    //
    public function map() {
        return $this->belongsTo(Map::class);
    }
}
