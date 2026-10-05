<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {

            $table->enum('refund_type',[
                'bank',
                'ewallet'
            ])->nullable()->after('video');

            $table->unsignedBigInteger('bank_id')
                  ->nullable()
                  ->after('refund_type');

            $table->unsignedBigInteger('ewallet_id')
                  ->nullable()
                  ->after('bank_id');

            $table->string('account_number')
                  ->nullable()
                  ->after('ewallet_id');

            $table->string('account_holder')
                  ->nullable()
                  ->after('account_number');

        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {

            $table->dropColumn([

                'refund_type',

                'bank_id',

                'ewallet_id',

                'account_number',

                'account_holder'

            ]);

        });
    }
};