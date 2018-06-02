<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Topo'
        ]);
        DB::table('roles')->insert([
            'name' => 'Meio'
        ]);
        DB::table('roles')->insert([
            'name' => 'Atirador'
        ]);
        DB::table('roles')->insert([
            'name' => 'Caçador'
        ]);
        DB::table('roles')->insert([
            'name' => 'Suporte'
        ]);
    }
}
