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
        Schema::create('proyek_lombas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemilu_event_id')->constrained('pemilu_events')->onDelete('cascade');
            $table->string('nama_proyek', 255);
            $table->string('tim_pengembang', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto_sampul', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyek_lombas');
    }
};
