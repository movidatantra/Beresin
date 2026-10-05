<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Refund extends Model
{
    protected $fillable = [

    'complaint_id',

    'order_id',

    'payment_id',

    'refund_key',

    'refund_method',

    'amount',

    'reason',

    'status',

    'processed_by',

    'response',

    'refunded_at',

];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function admin()
{
    return $this->belongsTo(
        User::class,
        'processed_by'
    );
}
}