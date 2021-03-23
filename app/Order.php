<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'kememberan_id', 'snap_url', 'metadata', 'status'
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
