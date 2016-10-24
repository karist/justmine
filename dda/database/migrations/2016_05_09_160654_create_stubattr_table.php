<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStubattrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stubattrs', function (Blueprint $table) {
            $table->string('stubname');
            $table->primary('stubname')->unique();
            $table->string('stubindo');
            $table->string('stubeng');
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
        Schema::drop('stubattrs');
    }
}
