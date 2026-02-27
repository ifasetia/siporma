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
        Schema::table('profiles', function (Blueprint $table) {

            $table->uuid('pr_pekerjaan_id')
                ->nullable()
                ->after('pr_kampus_id');

            $table->foreign('pr_pekerjaan_id')
                ->references('pk_id_pekerjaan')
                ->on('ms_pekerjaan')
                ->nullOnDelete();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
        });
    }
};
