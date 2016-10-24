<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDdaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Ddas', function (Blueprint $table) {
            DB::query("ALTER TABLE `mydda`.`ddas` CHANGE COLUMN `id` `id` varchar(12)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Ddas', function (Blueprint $table) {
            //
        });
    }
}
