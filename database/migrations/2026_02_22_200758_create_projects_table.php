<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
            $table->text('description')->nullable();

            // Catatan: Kalau satu project bisa pakai BANYAK teknologi (misal Laravel + React),
            // nanti sebaiknya pakai tabel pivot/bantuan. Tapi untuk sekarang biarkan string dulu nggak apa-apa.
            $table->string('technologies')->nullable();

            $table->string('document')->nullable();
            $table->json('links')->nullable();

            // Relasi ke User (Intern yang nge-upload)
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();

            // 👇 INI YANG BARU: Relasi ke Master Status Proyek
            // Kita pakai UUID karena sp_id di master status proyek bentuknya UUID
            $table->uuid('status_id')->nullable();
            // Sesuaikan 'sp_id' dan 'master_status_proyek' dengan nama kolom/tabel aslimu
            $table->foreign('status_id')->references('sp_id')->on('master_status_proyek')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
