<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'mentor_id', 'kategori_id', 'nama', 'image', 'sertifikat', 'harga',
        'level', 'deskripsi', 'sub_kategori'
    ];

    public function mentor()
    {
        return $this->belongsTo('App\Mentor');
    }

    public function kategori()
    {
        return $this->belongsTo('App\Kategori');
    }

    public function chapter()
    {
        return $this->hasMany('App\Chapter');
    }

    public function review()
    {
         return $this->hasMany('App\Review');
    }

    public function myCourse()
    {
        return $this->hasMany('App\MyCourse');
    }

}
