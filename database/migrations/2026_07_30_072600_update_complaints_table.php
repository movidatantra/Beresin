<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {

            // kolom baru
            $table->string('complaint_number',30)->after('id');

            $table->unsignedBigInteger('mitra_id')->after('user_id');

            $table->string('category',100)->after('mitra_id');

            $table->string('photo')->nullable()->after('complaint');

            $table->string('video')->nullable()->after('photo');

            $table->text('admin_response')->nullable()->after('video');

            $table->text('mitra_response')->nullable()->after('admin_response');

            $table->enum('status',[
                'pending',
                'waiting_mitra',
                'review',
                'approved',
                'rejected',
                'resolved'
            ])->default('pending')->change();

            $table->timestamp('resolved_at')->nullable()->after('status');

        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {

            $table->dropColumn([

                'complaint_number',

                'mitra_id',

                'category',

                'photo',

                'video',

                'admin_response',

                'mitra_response',

                'resolved_at'

            ]);

        });
    }
};