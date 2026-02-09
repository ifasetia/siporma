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
        Schema::create('ms_kampus', function (Blueprint $table) {
            $table->uuid('km_id')->primary();
            $table->string('km_nama_kampus');
            $table->string('km_kode_kampus', 20)->unique();
            $table->string('km_email')->unique();
            $table->text('km_alamat');
            $table->string('km_telepon', 15);
            $table->string('km_foto')->nullable(); // path foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_kampus');
    }
};
