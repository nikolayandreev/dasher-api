<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reservation_id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->bigInteger('employee_id')->nullable()->unsigned();
            $table->integer('quantity')->nullable();

            $table->foreign('reservation_id')
                  ->references('id')->on('reservations')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('service_id')
                  ->references('id')->on('services')
                  ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('employee_id')
                  ->references('id')->on('employees')
                  ->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_services');
    }
}
