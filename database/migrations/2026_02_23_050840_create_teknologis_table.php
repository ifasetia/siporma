<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ms_teknologi', function (Blueprint $table) {
            // Gunakan uuid dan set sebagai primary key
            $table->uuid('tk_id')->primary();
            $table->string('tk_nama');
            $table->string('tk_kategori');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ms_teknologi');
    }
};
