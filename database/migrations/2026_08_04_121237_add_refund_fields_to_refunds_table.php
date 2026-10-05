<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('refunds', function (Blueprint $table) {

            $table->enum('refund_method', [
                'manual',
                'midtrans'
            ])->default('manual')->after('refund_key');

            $table->foreignId('processed_by')
                  ->nullable()
                  ->after('status')
                  ->constrained('users')
                  ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('refunds', function (Blueprint $table) {

            $table->dropForeign(['processed_by']);

            $table->dropColumn([
                'refund_method',
                'processed_by'
            ]);

        });
    }
};