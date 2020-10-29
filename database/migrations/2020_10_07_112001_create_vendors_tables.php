<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('owner_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade')->onUpdate('cascade');
        });

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

        Schema::create('vendor_schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id')->unsigned();
            $table->smallInteger('day_of_week');
            $table->time('opens_at', '');
            $table->time('closes_at');

            $table->foreign('vendor_id')
                  ->references('id')->on('vendors')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['vendor_id', 'day_of_week']);
        });

        Schema::create('vendor_holidays', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id')->unsigned();
            $table->date('date_from');
            $table->date('date_to');

            $table->foreign('vendor_id')
                  ->references('id')->on('vendors')
                  ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('vendor_schedules');
        Schema::dropIfExists('vendor_holidays');
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('areas');
    }
}
