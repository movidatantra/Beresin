<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saldopencairan extends Model
{
    protected $table = 'saldopencairan';

    protected $fillable = [

        'mitra_id',
        'amount',
        'bank_name',
        'bank_account',
        'account_holder',
        'status'

    ];
}