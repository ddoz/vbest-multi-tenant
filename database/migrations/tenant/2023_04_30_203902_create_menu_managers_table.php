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
        Schema::create('menu_managers', function (Blueprint $table) {
            $table->id();
            $table->string("menu");
            $table->string("icon");
            $table->string("route");
            $table->string('is_required')->default("1");
            $table->string('hide')->default("0");
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
        Schema::dropIfExists('menu_managers');
    }
};
