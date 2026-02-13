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

            $table->uuid('pr_kampus_id')->nullable();

            $table->foreign('pr_kampus_id')
                ->references('km_id')
                ->on('ms_kampus')
                ->nullOnDelete();

        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {

            $table->dropForeign(['pr_kampus_id']);
            $table->dropColumn('pr_kampus_id');

        });
    }

};
