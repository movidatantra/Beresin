<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'tm_bank';

    protected $fillable = [
        'kode_bank',
        'nama_bank'
    ];
}