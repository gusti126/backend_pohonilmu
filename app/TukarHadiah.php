<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TukarHadiah extends Model
{
    protected $fillable = [
        'user_id', 'hadiah_id', 'metadata', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hadiah()
    {
        return $this->belongsTo('App\Hadiah');
    }
}
