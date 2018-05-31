<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mode;

class Map extends Model
{

    protected $fillable = [
        'name',
        'riot_id',
        'active',
        'modes'
    ];

    public function modes() {
        return $this->hasMany(Mode::class);
    }
}
