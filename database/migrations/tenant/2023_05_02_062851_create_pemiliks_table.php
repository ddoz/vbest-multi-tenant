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
        Schema::create('pemiliks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_kepemilikan_id'); // foreign key jenis kepemilikan 
            $table->string('nama');
            $table->unsignedBigInteger('kewarganegaraan_id'); // foreign key kewarganegaraan 
            $table->string('nomor_identitas');
            $table->string('npwp');
            $table->string('alamat');
            $table->unsignedBigInteger('provinsi_id'); //foreign key provinsi
            $table->unsignedBigInteger('kabupaten_id'); //foreign key kabupaten
            $table->unsignedBigInteger('kecamatan_id'); //foreign key kecamatan
            $table->unsignedBigInteger('kelurahan_id'); //foreign key kelurahan
            $table->string('jumlah_saham');
            $table->string('jenis_saham');
            $table->string('keterangan_tambahan')->nullable();
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
        Schema::dropIfExists('pemiliks');
    }
};
