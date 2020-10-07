<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status');
            $table->bigInteger('vendor_id')->unsigned();
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->date('date');
            $table->time('time');
            $table->time('time_to')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vendor_id')
                  ->references('id')->on('vendors')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('client_id')
                  ->references('id')->on('clients')
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
        Schema::dropIfExists('reservations');
    }
}
