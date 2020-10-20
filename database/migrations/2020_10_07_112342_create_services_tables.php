<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('color');
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_id')->unsigned();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->string('name');
            $table->integer('price');
            $table->integer('duration');
            $table->boolean('is_active');
            $table->timestamps();

            $table->foreign('vendor_id')
                  ->references('id')->on('vendors')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('category_id')
                  ->references('id')->on('service_categories')
                  ->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('service_employees', function (Blueprint $table) {
            $table->bigInteger('service_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();

            $table->primary(['service_id', 'employee_id']);

            $table->foreign('service_id')
                  ->references('id')->on('services')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('employee_id')
                  ->references('id')->on('employees')
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
        Schema::dropIfExists('services_employees');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
    }
}
