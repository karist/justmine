<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stubname');
            $table->string('rincian');
            $table->string('details');
            $table->timestamps();

            $table->foreign('stubname')->references('stubname')->on('stubattrs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stubs');
    }
}
