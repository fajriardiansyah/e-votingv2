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
        Schema::create('pemilu_events', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->boolean('aktif')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilu_events');
    }
};
