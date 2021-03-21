<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hadiah extends Model
{
    protected $fillable = [
        'image', 'note', 'jumlah_point'
    ];
}
