<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->timestamp('finished_at')
                ->nullable()
                ->after('status');

            $table->enum('customer_confirmation',[
                'pending',
                'approved',
                'complain'
            ])
            ->default('pending')
            ->after('finished_at');

        });

        DB::statement("
            ALTER TABLE orders
            MODIFY status ENUM(
                'pending',
                'diterima',
                'ditolak',
                'menuju_lokasi',
                'dikerjakan',
                'menunggu_konfirmasi',
                'komplain',
                'selesai',
                'dibatalkan'
            ) NOT NULL DEFAULT 'pending'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
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

        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn('finished_at');

            $table->dropColumn('customer_confirmation');

        });
    }
};