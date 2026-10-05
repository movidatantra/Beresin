<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [

        'order_id',
        'transaction_id',
        'order_code',
        'snap_token',
        'gross_amount',
        'payment_type',
        'bank',
        'va_number',
        'payment_code',
        'transaction_status',
        'fraud_status',
        'transaction_time',
        'settlement_time',
        'expiry_time',

    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function refund()
{
    return $this->hasOne(Refund::class);
}
}