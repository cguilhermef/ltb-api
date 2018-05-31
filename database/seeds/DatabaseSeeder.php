<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->delete();
        DB::table('tiers')->delete();
        DB::table('modes')->delete();
        DB::table('maps')->delete();
        $this->call([
            RegionsTableSeeder::class,
            TiersTableSeeder::class,
            MapsTableSeeder::class,
            ModesTableSeeder::class
        ]);
    }
}
