<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tags')->insert([
            'tagname' => 'Henkel'
        ]);
        DB::table('tags')->insert([
            'tagname' => 'Schwarzkopf'
        ]);
        DB::table('tags')->insert([
            'tagname' => 'Neuherz'
        ]);
    }
}
