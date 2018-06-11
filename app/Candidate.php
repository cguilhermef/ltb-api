<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'user_id',
        'vacancy_id'
    ];

    public $timestamps = false;

    public function vacancy() {
        return $this->belongsTo(Vacancy::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
