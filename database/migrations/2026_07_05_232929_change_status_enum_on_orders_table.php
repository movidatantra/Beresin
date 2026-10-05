<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE orders
            MODIFY status ENUM(
                'pending',
                'diterima',
                'ditolak',
                'menuju_lokasi',
                'dikerjakan',
                'selesai',
                'dibatalkan'
            ) NOT NULL DEFAULT 'pending'
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE orders
            MODIFY status ENUM(
                'pending',
                'diproses',
                'selesai',
                'dibatalkan'
            ) NOT NULL DEFAULT 'pending'
        ");
    }
};
