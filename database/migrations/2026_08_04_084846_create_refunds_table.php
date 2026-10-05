<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {

            $table->id();

            $table->foreignId('complaint_id')
                  ->constrained('complaints')
                  ->cascadeOnDelete();

            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            $table->foreignId('payment_id')
                  ->constrained('payments')
                  ->cascadeOnDelete();

            // refund dari Midtrans
            $table->string('refund_key')->nullable();

            $table->decimal('amount',12,2);

            $table->text('reason')->nullable();

            $table->enum('status',[
                'pending',
                'success',
                'failed'
            ])->default('pending');

            $table->longText('response')->nullable();

            $table->timestamp('refunded_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};