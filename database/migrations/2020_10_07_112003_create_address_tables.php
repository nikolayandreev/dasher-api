<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('vendor_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id')->unsigned();
            $table->bigInteger('area_id')->unsigned();
            $table->string('street');
            $table->string('additional')->nullable();

            $table->foreign('area_id')
                  ->references('id')->on('areas')
                  ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('vendor_id')
                  ->references('id')->on('vendors')
                  ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('areas');
    }
}
