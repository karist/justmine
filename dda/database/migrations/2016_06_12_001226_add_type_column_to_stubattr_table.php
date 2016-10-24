<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeColumnToStubattrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stubattrs', function (Blueprint $table) {
            $table->string('type');
            $table->integer('length')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stubattrs', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('length');
        });
    }
}
