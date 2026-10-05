<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {

            $table->id();

            // Mitra
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Saldo yang dicairkan
            $table->decimal('amount',15,2);

            // Bank / Ewallet
            $table->enum('withdraw_type',['bank','ewallet']);

            // Brick Code
            $table->string('destination');

            // Nomor rekening / nomor HP
            $table->string('account_number');

            // Nama rekening
            $table->string('account_name');

            // Status
            $table->enum('status',[
                'pending',
                'processing',
                'success',
                'failed',
                'rejected'
            ])->default('pending');

            // ID dari Xendit nanti
            $table->string('xendit_id')->nullable();

            // Catatan admin
            $table->text('note')->nullable();

            // Admin yang memproses
            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};