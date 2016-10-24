<?php

use Illuminate\Database\Seeder;

class StubattrsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Stubattrs')->insert([
        	'stubname' => 'bulan';
        	'stubindo' => 'Bulan';
        	'stubeng' => 'Month';
        ]);
    }
}
