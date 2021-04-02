<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTripay extends Model
{
    protected $fillable = [
        'status', 'no_referensi', 'kode_pembayaran', 'jumlah_tagihan', 'snap_url',
        'metadata', 'user_id', 'kememberan_id'
    ];
}
