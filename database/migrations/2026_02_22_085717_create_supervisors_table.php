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
        Schema::create('supervisors', function (Blueprint $table) {
            $table->uuid('sp_id')->primary(); // Pakai UUID biar aman
            $table->string('sp_nip', 20)->unique();
            $table->string('sp_nama', 100);
            $table->string('sp_jabatan', 50);
            $table->string('sp_divisi', 50); // Divisi di Kominfo
            $table->string('sp_email')->unique();
            $table->string('sp_telepon', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisors');
    }
};
