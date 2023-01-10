<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('category')->index()->unsigned();
            $table->string('description');
            $table->string('images');
            $table->string('condition');
            $table->string('buy');
            $table->string('mobile');
            $table->string('landline');
            $table->string('email');
            $table->integer('owner')->index()->unsigned();
            $table->boolean('isApprove')->default('0');
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
        Schema::dropIfExists('ads');
    }
}
