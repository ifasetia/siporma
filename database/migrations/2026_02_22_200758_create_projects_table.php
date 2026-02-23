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
        Schema::create('projects', function (Blueprint $table) {

    $table->uuid('id')->primary();

    $table->string('title');
    $table->text('description')->nullable();
    $table->string('technologies')->nullable();
    $table->string('document')->nullable();
    $table->json('links')->nullable();

    $table->uuid('created_by');

    $table->foreign('created_by')
          ->references('id')
          ->on('users')
          ->cascadeOnDelete();

    $table->enum('status', ['menunggu','disetujui','ditolak'])
          ->default('menunggu');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
