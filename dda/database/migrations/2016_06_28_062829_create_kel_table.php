<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Kelurahans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_kel');
            $table->string('nama_kel');
            $table->string('prov');
            $table->string('kabkot');
            $table->string('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Kelurahans');
    }
}
