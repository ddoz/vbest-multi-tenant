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
        Schema::create('sertifikasi_tenaga_ahlis', function (Blueprint $table) {
            $table->id();
            $table->string("jenis_sertifikat");
            $table->string("lampiran")->nullable();
            $table->string("bidang");
            $table->string("tingkatan");
            $table->date("diterbitkan");
            $table->date("berakhir");
            $table->string("penerbit");
            $table->unsignedBigInteger('tenaga_ahli_id'); // foreign key tenaga ahli
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
        Schema::dropIfExists('sertifikasi_tenaga_ahlis');
    }
};
