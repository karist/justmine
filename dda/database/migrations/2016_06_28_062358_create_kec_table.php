<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Kecamatans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_kec');
            $table->string('nama_kec');
            $table->string('prov');
            $table->string('kabkot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Kecamatans');
    }
}
