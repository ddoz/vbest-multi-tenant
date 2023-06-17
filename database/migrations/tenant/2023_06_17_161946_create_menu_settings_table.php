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
        Schema::create('menu_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_manager_id');
            $table->string('not_required')->default("0");
            $table->string('hide')->default("0");
            $table->unsignedBigInteger('identitas_vendor_id');
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
        Schema::dropIfExists('menu_settings');
    }
};
