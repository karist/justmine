<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dropcolumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_provs', function (Blueprint $table) {
             $table->dropColumn('created_at');
             $table->dropColumn('updated_at');
        });
        Schema::table('master_kabs', function (Blueprint $table) {
             $table->dropColumn('created_at');
             $table->dropColumn('updated_at');
        });
        Schema::table('master_kecs', function (Blueprint $table) {
             $table->dropColumn('created_at');
             $table->dropColumn('updated_at');
        });
        Schema::table('master_desas', function (Blueprint $table) {
             $table->dropColumn('created_at');
             $table->dropColumn('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_provs', function (Blueprint $table) {
            //
        });
    }
}
