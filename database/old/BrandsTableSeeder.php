<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organisation_ids = DB::table('organisations')->pluck('id')->toArray();

        DB::table('brands')->insert([
            'brandname' => 'Gurken',
            'organisation_id' => $organisation_ids[0]
        ]);
        DB::table('brands')->insert([
            'brandname' => 'Pfefferoni',
            'organisation_id' => $organisation_ids[0]
        ]);
        DB::table('brands')->insert([
            'brandname' => 'Spezialitäten',
            'organisation_id' => $organisation_ids[0]
        ]);
        DB::table('brands')->insert([
            'brandname' => 'Salate',
            'organisation_id' => $organisation_ids[0]
        ]);
        DB::table('brands')->insert([
            'brandname' => 'Sauerkraut & Rotkraut',
            'organisation_id' => $organisation_ids[0]
        ]);
    }
}
