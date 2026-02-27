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
            $table->uuid('pr_km_id')->nullable();
            $table->uuid('pr_js_id')->nullable();
            $table->uuid('pr_id_pekerjaan')->nullable();
            $table->uuid('user_id');
            $table->uuid('pr_sp_id');


            // RELASI KE USERS
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('pr_km_id')
                ->references('km_id')
                ->on('ms_kampus')
                ->nullOnDelete();

            $table->foreign('pr_js_id')
                ->references('js_id')
                ->on('ms_jurusan')
                ->nullOnDelete();

            $table->foreign('pr_id_pekerjaan')
                ->references('pk_id_pekerjaan')
                ->on('ms_pekerjaan')
                ->nullOnDelete();
            
            $table->foreign('pr_sp_id')
                ->references('sp_id')
                ->on('supervisors')
                ->nullOnDelete();

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
            $table->string('pr_nip')->nullable();
            $table->date('pr_internship_start')->nullable();
            $table->date('pr_internship_end')->nullable();
            $table->string('pr_instagram')->nullable();
            $table->string('pr_linkedin')->nullable();
            $table->string('pr_github')->nullable();
            $table->string('pr_whatsapp')->nullable();
            $table->string('pr_facebook')->nullable();


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
