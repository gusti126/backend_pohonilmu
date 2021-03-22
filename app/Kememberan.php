<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kememberan extends Model
{
    protected $fillable = [
        'nama', 'harga', 'akses_kelas', 'get_point'
    ];

    public function berlangganan()
    {
        return $this->hasMany('App\Berlangganan');
    }
}
