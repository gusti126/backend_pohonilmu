<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berlangganan extends Model
{
    protected $fillable = [
        'user_id', 'kememberan_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function kememberan()
    {
        return $this->belongsTo('App\Kememberan');
    }
}
