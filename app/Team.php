<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'abbreviation',
        'name',
        'tier_min',
        'user_id'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function modes() {
        return $this->belongsToMany(Mode::class, 'teams_has_modes', 'teams_id', 'modes_id');
    }

    public function vacancies() {
        return $this->hasMany(Vacancy::class);
    }

    public function members() {
        return $this->hasMany(Member::class);
    }
}
