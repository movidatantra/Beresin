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
    Schema::table('orders', function (Blueprint $table) {

        $table->string('work_photo')->nullable();

        $table->string('work_video')->nullable();

        $table->text('work_note')->nullable();

    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {

        $table->dropColumn([
            'work_photo',
            'work_video',
            'work_note'
        ]);

    });
}
};
