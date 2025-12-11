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
        Schema::table('proyek_lombas', function (Blueprint $table) {
            // Tambahkan kolom 'url_proyek' setelah kolom 'tim_pengembang'
            $table->string('url_proyek', 255)->nullable()->after('tim_pengembang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proyek_lombas', function (Blueprint $table) {
            // Hapus kolom 'url_proyek' jika di rollback
            $table->dropColumn('url_proyek');
        });
    }
};
