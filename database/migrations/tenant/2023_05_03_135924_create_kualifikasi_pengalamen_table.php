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
        Schema::create('kualifikasi_pengalaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kualifikasi_bidang_id'); // foreign key kualifikasi bidang
            $table->unsignedBigInteger('pengalaman_id'); // foreign key pengalaman
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
        Schema::dropIfExists('kualifikasi_pengalaman');
    }
};
