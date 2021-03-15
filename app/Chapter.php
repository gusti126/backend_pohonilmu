<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'course_id', 'nama'
    ];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function lesson()
    {
        return $this->hasMany('App\Lesson');
    }
}
