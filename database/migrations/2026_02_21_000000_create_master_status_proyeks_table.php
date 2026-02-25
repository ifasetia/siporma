<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_status_proyek', function (Blueprint $table) {
            // Kita gunakan UUID agar konsisten dengan gaya codingmu sebelumnya
            $table->uuid('sp_id')->primary();
            $table->string('sp_nama_status');
            $table->string('sp_warna')->nullable(); // Untuk menyimpan class warna Tailwind (misal: bg-success)
            $table->text('sp_keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_status_proyek');
    }
};
