<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            // PELANGGAN

            $table->foreignId('user_id');

            // MITRA

            $table->foreignId('mitra_id');

            // SERVICE

            $table->foreignId('service_id');

            // ORDER

            $table->date('jadwal');

            $table->text('address');

            $table->text('note')->nullable();

            // STATUS ORDER

            $table->enum('status', [

                'pending',

                'diproses',

                'selesai',

                'dibatalkan'

            ])->default('pending');

            // PAYMENT

            $table->enum('payment_status', [

                'belum_bayar',

                'menunggu_verifikasi',

                'lunas'

            ])->default('belum_bayar');

            $table->string('payment_method')->nullable();

            $table->string('payment_proof')->nullable();

            $table->timestamps();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};