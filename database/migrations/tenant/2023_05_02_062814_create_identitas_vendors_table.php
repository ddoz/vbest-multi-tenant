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
        Schema::create('identitas_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('bentuk_usaha');
            $table->string('nama_usaha');
            $table->string('npwp');
            $table->string('status_usaha');
            $table->string('jenis_usaha');
            $table->string('produk_usaha');
            $table->string('total_modal_usaha');
            $table->string('alamat_usaha');
            $table->unsignedBigInteger('provinsi_id'); //foreign key provinsi
            $table->unsignedBigInteger('kabupaten_id'); //foreign key kabupaten
            $table->unsignedBigInteger('kecamatan_id'); //foreign key kecamatan
            $table->unsignedBigInteger('kelurahan_id'); //foreign key kelurahan
            $table->string('kode_pos');
            $table->string('no_telp');
            $table->string('fax');
            $table->string('nama_pic');
            $table->string('telp_pic');
            $table->string('alamat_pic');
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
        Schema::dropIfExists('identitas_vendors');
    }
};
