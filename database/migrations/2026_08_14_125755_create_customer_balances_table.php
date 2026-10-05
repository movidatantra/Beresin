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
       Schema::create('customer_balance_transactions', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
          ->constrained('users')
          ->cascadeOnDelete();

    $table->foreignId('order_id')
          ->nullable()
          ->constrained('orders')
          ->nullOnDelete();

    $table->enum('type', [
        'refund',
        'topup',
        'payment',
        'withdraw'
    ]);

    $table->decimal('amount', 15, 2);

    $table->decimal('balance_before', 15, 2)->default(0);

    $table->decimal('balance_after', 15, 2)->default(0);

    $table->string('description')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_balances');
    }
};
