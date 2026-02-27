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
        Schema::create('project_teknologi', function (Blueprint $table) {
        $table->uuid('project_id');
        $table->uuid('teknologi_id');

        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        $table->foreign('teknologi_id')->references('tk_id')->on('ms_teknologi')->onDelete('cascade');

        $table->primary(['project_id', 'teknologi_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_teknologi');
    }
};
