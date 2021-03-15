<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $fillable = [
        'nama', 'email', 'profesi', 'image', 'no_rekening', 'user_id'
    ];

    public function course()
    {
        return $this->hasMany('App\Course');
    }
}
