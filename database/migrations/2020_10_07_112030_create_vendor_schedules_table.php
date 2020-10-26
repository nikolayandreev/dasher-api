<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_schedules');
    }
}
