<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiManual extends Model
{
   protected $fillable = [
       'user_id', 'kememberan_id', 'bukti_pembayaran', 'status', 'referal'
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
