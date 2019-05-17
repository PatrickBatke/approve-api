<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'name' => 'Folder'
        ]);
        DB::table('types')->insert([
            'name' => 'Verpackung'
        ]);
        DB::table('types')->insert([
            'name' => 'Website'
        ]);
    }
}
