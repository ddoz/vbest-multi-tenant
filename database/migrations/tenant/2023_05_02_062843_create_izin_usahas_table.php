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
        Schema::create('izin_usahas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("jenis_izin_usaha_id"); // foreign key jenis izin usaha            
            $table->string('no_surat');
            $table->string('seumur_hidup');
            $table->date('berlaku_sampai')->nullable();
            $table->string('kualifikasi');
            $table->string('instansi_penerbit');
            $table->string('keterangan')->nullable();
            $table->string('scan_dokumen');
            $table->enum('status_dokumen', ['PENDING','VERIFIED','APPROVED','REVISED'])->default('PENDING');
            $table->datetime('tgl_verifikasi')->nullable();
            $table->unsignedBigInteger('verified_id')->nullable(); // foreign key user
            $table->unsignedBigInteger('user_id'); // foreign key user
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
        Schema::dropIfExists('izin_usahas');
    }
};
