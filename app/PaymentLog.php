<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = [
        'status', 'payment_type', 'raw_response', 'order_id'
    ];
}
