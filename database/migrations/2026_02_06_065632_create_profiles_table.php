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
        $table->id();

        $table->uuid('user_id');
        $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();


        // UMUM
        $table->string('nama');
        $table->string('no_hp')->nullable();
        $table->text('alamat')->nullable();
        $table->string('photo')->nullable();
        $table->string('jenis_kelamin')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->string('status')->nullable();

        // INTERN
        $table->string('nim')->nullable();
        $table->string('kampus')->nullable();
        $table->string('jurusan')->nullable();
        $table->date('internship_start')->nullable();
        $table->date('internship_end')->nullable();
        $table->string('supervisor_name')->nullable();
        $table->string('supervisor_contact')->nullable();

        // ADMIN + SUPER ADMIN
        $table->string('posisi')->nullable();

        $table->timestamps();
    });
}
};
