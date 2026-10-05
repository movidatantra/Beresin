<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    // 1. WAJIB DITAMBAHKAN BIAR BACA TABEL SALDOPENCAIRAN
    protected $table = 'saldopencairan'; 

    protected $fillable = [
        'mitra_id', 'amount', 'withdraw_type', 'bank_name', 
        'bank_account', 'account_holder', 'status', 'bank_id', 'ewallet_id'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    // 2. TAMBAHKAN 'mitra_id' DI SINI
    public function user()
    {
        // Kasih tau Laravel kalau foreign key-nya itu mitra_id, bukan user_id
        return $this->belongsTo(User::class, 'mitra_id'); 
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}