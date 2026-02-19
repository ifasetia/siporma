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
            $table->string('pr_instagram')->nullable()->after('pr_status');
            $table->string('pr_linkedin')->nullable()->after('pr_instagram');
            $table->string('pr_github')->nullable()->after('pr_linkedin');
            $table->string('pr_whatsapp')->nullable()->after('pr_whatsapp');
            $table->string('pr_facebook')->nullable()->after('pr_facebook');

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
