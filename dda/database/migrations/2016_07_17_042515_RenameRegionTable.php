<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('provinsis', 'master_provs');
        Schema::rename('kabkots', 'master_kabs');
        Schema::rename('kecamatans', 'master_kecs');
        Schema::rename('kelurahans', 'master_desas');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
