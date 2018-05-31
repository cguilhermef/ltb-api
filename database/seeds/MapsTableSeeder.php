<?php

use Illuminate\Database\Seeder;

class MapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('maps')->insert([
            'id' => 11,
            'name'=> "Summoner's Rift",
            'active' => 1
        ]);
        DB::table('maps')->insert([
            'id' => 10,
            'name'=> "Twisted Treeline",
            'active' => 1
        ]);
        DB::table('maps')->insert([
            'id' => 12,
            'name'=> "Howling Abyss",
            'active' => 1
        ]);
    }
}
