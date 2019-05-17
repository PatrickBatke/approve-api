<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
            'size' => '720 ml'
        ]);
        DB::table('sizes')->insert([
            'size' => '370 ml'
        ]);
        DB::table('sizes')->insert([
            'size' => '212 ml'
        ]);
        DB::table('sizes')->insert([
            'size' => '500 g'
        ]);
        DB::table('sizes')->insert([
            'size' => '400 g'
        ]);
        DB::table('sizes')->insert([
            'size' => '350 g'
        ]);

    }
}
