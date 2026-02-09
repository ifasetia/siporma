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
        Schema::create('ms_pekerjaan', function (Blueprint $table) {
            $table->uuid('pk_id_pekerjaan')->primary();
            $table->string('pk_kode_tipe_pekerjaan');
            $table->string('pk_nama_pekerjaan');
            $table->text('pk_deskripsi_pekerjaan');
            $table->string('pk_level_pekerjaan');
            $table->string('pk_estimasi_durasi_hari');
            $table->string('pk_minimal_skill');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_pekerjaan');
    }
};
