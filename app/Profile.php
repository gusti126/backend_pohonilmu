<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'image', 'referal', 'user_id', 'no_tlp',
        'alamat', 'tanggal_lahir', 'point', 'jenis_kelamin'

    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
