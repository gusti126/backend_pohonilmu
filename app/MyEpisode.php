<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyEpisode extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'lesson_id'
    ];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }
}
