<?php

use Illuminate\Database\Seeder;

class TiersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tiers')->insert([
            'name' => 'Não ranqueado',
            'riot_id' => 'UNRANKED'
        ]);
        DB::table('tiers')->insert([
            'name' => 'Bronze',
            'riot_id' => 'BRONZE'
        ]);
        DB::table('tiers')->insert([
            'name' => 'Prata',
            'riot_id' => 'SILVER'
        ]);
        DB::table('tiers')->insert([
            'name' => 'Ouro',
            'riot_id' => 'GOLD'
        ]);
        DB::table('tiers')->insert([
            'name' => 'Platina',
            'riot_id' => 'PLATINUM'
        ]);
        DB::table('tiers')->insert([
            'name' => 'Diamante',
            'riot_id' => 'DIAMOND'
        ]);
        DB::table('tiers')->insert([
            'name' => 'Mestre',
            'riot_id' => 'MASTER'
        ]);
        DB::table('tiers')->insert([
            'name' => 'Desafiante',
            'riot_id' => 'CHALLENGER'
        ]);
    }
}
