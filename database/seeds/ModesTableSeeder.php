<?php

use Illuminate\Database\Seeder;

class ModesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modes')->insert([
            'name' => 'Escolha às cegas',
            'riot_id' => 430,
            'map_id' => 11,
            'active' => 1
        ]);
        DB::table('modes')->insert([
            'name' => 'Escolha alternada',
            'riot_id' => 400,
            'map_id' => 11,
            'active' => 1
        ]);
        DB::table('modes')->insert([
            'name' => 'Ranqueada solo/duo',
            'riot_id' => 420,
            'map_id' => 11,
            'active' => 1
        ]);
        DB::table('modes')->insert([
            'name' => 'Ranqueada flexível',
            'riot_id' => 440,
            'map_id' => 11,
            'active' => 1
        ]);
        DB::table('modes')->insert([
            'name' => 'Escolha às cegas',
            'riot_id' => 460,
            'map_id' => 10,
            'active' => 1
        ]);
        DB::table('modes')->insert([
            'name' => 'Ranqueada',
            'riot_id' => 470,
            'map_id' => 10,
            'active' => 1
        ]);
        DB::table('modes')->insert([
            'name' => 'Clash',
            'riot_id' => 700,
            'map_id' => 11,
            'active' => 1
        ]);
        DB::table('modes')->insert([
            'name' => 'Aram',
            'riot_id' => 450,
            'map_id' => 12,
            'active' => 1
        ]);
    }
}
