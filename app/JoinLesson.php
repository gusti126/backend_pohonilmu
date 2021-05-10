<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinLesson extends Model
{
    protected $fillable = [
        'lesson_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }
}
