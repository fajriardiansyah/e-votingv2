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
        Schema::table('log_suaras', function (Blueprint $table) {
            // Kolom baru untuk segmentasi voter
            $table->string('tipe_voter', 100)->nullable()->after('identitas_voter'); // Contoh: Internal, Eksternal
            $table->string('kategori_internal', 100)->nullable()->after('tipe_voter'); // Contoh: Mahasiswa, Dosen, Staff
            
            // Kolom baru untuk data Eksternal
            $table->string('jabatan_eksternal', 255)->nullable();
            $table->string('nama_perusahaan', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_suaras', function (Blueprint $table) {
            $table->dropColumn('tipe_voter');
            $table->dropColumn('kategori_internal');
            $table->dropColumn('jabatan_eksternal');
            $table->dropColumn('nama_perusahaan');
        });
    }
};
