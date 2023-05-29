<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kualifikasi_izin_usahas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kualifikasi_bidang_id'); // foreign key kualifikasi bidang
            $table->unsignedBigInteger('izin_usaha_id'); // foreign key izin usaha
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kualifikasi_izin_usahas');
    }
};
