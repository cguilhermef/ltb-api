<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            'name' => 'Brasil',
            'abbreviation' => 'BR',
            'riot_id' => 'BR1'
        ]);
        DB::table('regions')->insert([
            'name' => 'EU Nordic & East',
            'abbreviation' => 'EUN',
            'riot_id' => 'EUN1'
        ]);
        DB::table('regions')->insert([
            'name' => 'EU West',
            'abbreviation' => 'EUW',
            'riot_id' => 'EUW1'
        ]);
        DB::table('regions')->insert([
            'name' => 'Japan',
            'abbreviation' => 'JP',
            'riot_id' => 'JP1'
        ]);
        DB::table('regions')->insert([
            'name' => 'Korea',
            'abbreviation' => 'KR',
            'riot_id' => 'KR'
        ]);
        DB::table('regions')->insert([
            'name' => 'Latin America North',
            'abbreviation' => 'LAN',
            'riot_id' => 'LA1'
        ]);
        DB::table('regions')->insert([
            'name' => 'Latin America South',
            'abbreviation' => 'LAS',
            'riot_id' => 'LA2'
        ]);
        DB::table('regions')->insert([
            'name' => 'North America',
            'abbreviation' => 'NA',
            'riot_id' => 'NA1'
        ]);
        DB::table('regions')->insert([
            'name' => 'Oceania',
            'abbreviation' => 'OC',
            'riot_id' => 'OC1'
        ]);
        DB::table('regions')->insert([
            'name' => 'Russia',
            'abbreviation' => 'RU',
            'riot_id' => 'RU'
        ]);
        DB::table('regions')->insert([
            'name' => 'Turkey',
            'abbreviation' => 'TR',
            'riot_id' => 'TR1'
        ]);
    }
}
