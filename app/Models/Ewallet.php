<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ewallet extends Model
{
    protected $table = 'tm_ewallet';

    protected $fillable = [
        'kode_wallet',
        'nama_wallet'
    ];
}