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
        Schema::table('pemilu_events', function (Blueprint $table) {
            // Tambahkan kolom timestamp untuk waktu mulai dan selesai
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemilu_events', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
};
