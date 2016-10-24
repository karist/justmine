<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKabkotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Kabkots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_kabkot');
            $table->string('nama_kabkot');
            $table->string('prov');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Kabkots');
    }
}
