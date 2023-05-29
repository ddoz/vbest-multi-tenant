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
        Schema::create('tenaga_ahlis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_tenaga_ahli_id'); // foreign key jenis tenaga ahli
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('nomor_identitas');
            $table->string('npwp');
            $table->date('tanggal_lahir');
            $table->unsignedBigInteger('kewarganegaraan_id'); // foreign key kewarganegaraan 
            $table->string('email');
            $table->string('alamat');
            $table->unsignedBigInteger('provinsi_id'); //foreign key provinsi
            $table->unsignedBigInteger('kabupaten_id'); //foreign key kabupaten
            $table->unsignedBigInteger('kecamatan_id'); //foreign key kecamatan
            $table->unsignedBigInteger('kelurahan_id'); //foreign key kelurahan
            $table->string('pendidikan_akhir');
            $table->string('jabatan');
            $table->string('profesi_keahlian');
            $table->string('lama_pengalaman');
            $table->string('status_kepegawaian');
            $table->string('keterangan_tambahan')->nullable();
            $table->string('scan_dokumen');
            $table->text('riwayat_penyakit')->nullable();
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
        Schema::dropIfExists('tenaga_ahlis');
    }
};
