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
        Schema::create('pengalaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kontrak');
            $table->text('lingkup_pekerjaan');
            $table->string('nomor_kontrak');
            $table->unsignedBigInteger('kategori_pekerjaan_id'); // foreign key kategori pekerjaan
            $table->date('pelaksanaan_kontrak');
            $table->date('selesai_kontrak');
            $table->date('serah_terima_pekerjaan');
            $table->string('nilai_kontrak');
            $table->string('presentase_pekerjaan');
            $table->date('tanggal_progress');
            $table->string('keterangan')->nullable();
            $table->string('scan_dokumen');
            $table->string('nama_alamat_proyek');
            $table->unsignedBigInteger('lokasi_pekerjaan_provinsi_id'); //foreign key provinsi
            $table->unsignedBigInteger('lokasi_pekerjaan_kabupaten_id'); //foreign key kabupaten
            $table->unsignedBigInteger('lokasi_pekerjaan_kecamatan_id'); //foreign key kecamatan
            $table->unsignedBigInteger('lokasi_pekerjaan_kelurahan_id'); //foreign key kelurahan
            $table->string('instansi_pengguna');
            $table->string('alamat_instansi');
            $table->unsignedBigInteger('instansi_provinsi_id'); //foreign key provinsi
            $table->unsignedBigInteger('instansi_kabupaten_id'); //foreign key kabupaten
            $table->unsignedBigInteger('instansi_kecamatan_id'); //foreign key kecamatan
            $table->unsignedBigInteger('instansi_kelurahan_id'); //foreign key kelurahan
            $table->string('telpon_instansi');
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
        Schema::dropIfExists('pengalaman');
    }
};
