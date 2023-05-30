<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_change_pelaporan_pajaks', function (Blueprint $table) {
            $table->id();
            $table->text("state_change");
            $table->enum('tipe', ['CHANGE','VERIFY'])->default('CHANGE');
            $table->unsignedBigInteger('pelaporan_pajak_id'); 
            $table->unsignedBigInteger('user_id'); 
            $table->timestamps();
        });

        Artisan::call('db:seed', []);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_change_pelaporan_pajaks');
    }
};
