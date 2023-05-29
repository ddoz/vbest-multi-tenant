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
        Schema::create('log_change_penguruses', function (Blueprint $table) {
            $table->id();
            $table->text("state_change");
            $table->enum('tipe', ['CHANGE','VERIFY'])->default('CHANGE');
            $table->unsignedBigInteger('pengurus_id'); 
            $table->unsignedBigInteger('user_id'); 
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
        Schema::dropIfExists('log_change_penguruses');
    }
};
