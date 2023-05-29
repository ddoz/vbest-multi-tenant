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
        Schema::create('pengalaman_tenaga_ahlis', function (Blueprint $table) {
            $table->id();
            $table->string('tahun');
            $table->string('uraian');
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
        Schema::dropIfExists('pengalaman_tenaga_ahlis');
    }
};
