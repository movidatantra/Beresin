<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            // Relasi ke order
            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Midtrans
            $table->string('transaction_id')->nullable();
            $table->string('order_code')->nullable();
            $table->string('snap_token')->nullable();

            // Informasi pembayaran
            $table->decimal('gross_amount', 12, 2);
            $table->string('payment_type')->nullable();
            $table->string('bank')->nullable();
            $table->string('va_number')->nullable();
            $table->string('payment_code')->nullable();

            // Status dari Midtrans
            $table->enum('transaction_status', [
                'pending',
                'settlement',
                'capture',
                'expire',
                'cancel',
                'deny',
                'refund'
            ])->default('pending');

            $table->string('fraud_status')->nullable();

            // Waktu transaksi
            $table->timestamp('transaction_time')->nullable();
            $table->timestamp('settlement_time')->nullable();
            $table->timestamp('expiry_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};