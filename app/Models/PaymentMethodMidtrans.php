<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodMidtrans extends Model
{
    protected $table = 'tm_payment_method';

    protected $fillable = [

        'code',

        'name',

        'category',

        'icon',

        'is_active'

    ];
}