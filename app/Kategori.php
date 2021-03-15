<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama'
    ];

    public function course()
    {
        return $this->hasMany('App\Course');
    }
}
