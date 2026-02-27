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
        Schema::create('profiles', function (Blueprint $table) {

            // PRIMARY KEY
            $table->uuid('pr_id')->primary();

            // RELASI KE USERS
            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            // =====================
            // UMUM (SEMUA ROLE)
            // =====================
            $table->string('pr_nama');
            $table->string('pr_no_hp')->nullable();
            $table->text('pr_alamat')->nullable();
            $table->string('pr_photo')->nullable(); // path foto
            $table->string('pr_jenis_kelamin')->nullable();
            $table->date('pr_tanggal_lahir')->nullable();
            $table->string('pr_status')->nullable();

            // =====================
            // KHUSUS INTERN
            // =====================
            $table->string('pr_nim')->nullable();
            $table->string('pr_kampus')->nullable();
            $table->string('pr_jurusan')->nullable();
            $table->date('pr_internship_start')->nullable();
            $table->date('pr_internship_end')->nullable();
            $table->string('pr_supervisor_name')->nullable();
            $table->string('pr_supervisor_contact')->nullable();
            $table->uuid('pr_pekerjaan_id')->nullable();

            // =====================
            // KHUSUS ADMIN + SUPER ADMIN
            // =====================
            $table->string('pr_posisi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
