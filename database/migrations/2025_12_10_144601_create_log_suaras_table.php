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
        Schema::create('log_suaras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemilu_event_id')->constrained('pemilu_events')->onDelete('cascade');
            $table->foreignId('proyek_lomba_id')->constrained('proyek_lombas')->onDelete('cascade');
            
            // Kolom untuk identifikasi voter dan pembatasan (IP/Device)
            $table->string('identitas_voter', 255)->nullable(); 
            $table->string('ip_pemilih', 45); 
            
            // FIX: Ubah dari TEXT menjadi STRING agar unique index berfungsi
            $table->string('perangkat_pemilih', 500); 
            
            $table->timestamps();
            
            // Constraint Unik
            $table->unique(['pemilu_event_id', 'ip_pemilih', 'perangkat_pemilih'], 'unique_vote_per_device');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_suaras');
    }
};
