<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class Properties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('tittle');
            $table->string('images');
            $table->string('buy');
            $table->string('province');
            $table->string('city');
            $table->string('town');
            $table->string('residential_type');
            $table->string('living_area_square_meters');
            $table->string('running_water');
            $table->string('electricity');
            $table->string('restroom');
            $table->string('room_arrangement');
            $table->string('number_of_rooms');
            $table->string('additional_info');
            $table->string("security");
            $table->string("isRentOrSale");
            $table->string('mobile');
            $table->string('landline');
            $table->string('email');
            $table->string('isApprove')->default('0');
            $table->integer('owner')->index()->unsigned();
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
        Schema::dropIfExists('properties');
    }
}