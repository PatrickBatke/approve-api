<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand_ids = DB::table('brands')->pluck('id')->toArray();
        $type_ids = DB::table('types')->pluck('id')->toArray();

        DB::table('products')->insert([
            'productname' => 'Delikatess Gurken',
            'description' => 'süß-sauer | der Klassiker',
            'brand_id' => $brand_ids[0],
            'type_id' => $type_ids[0]
        ]);

        DB::table('products')->insert([
            'productname' => 'Schlemmer Gurken',
            'description' => 'süß-sauer | klein & knackig',
            'brand_id' => $brand_ids[0],
            'type_id' => $type_ids[0]
        ]);

        DB::table('products')->insert([
            'productname' => 'Gewürz Gurken',
            'description' => 'sauer-salzig',
            'brand_id' => $brand_ids[0],
            'type_id' => $type_ids[0]
        ]);

        DB::table('products')->insert([
            'productname' => 'Pfefferoni',
            'description' => 'mild | scharf | Kirsch | Sonnen | Piccolo | Pizza | Bonbon | Minis | Snack',
            'brand_id' => $brand_ids[1],
            'type_id' => $type_ids[0]
        ]);

        DB::table('products')->insert([
            'productname' => 'Krach-Pfefferoni',
            'description' => 'mild - handgelegt',
            'brand_id' => $brand_ids[1],
            'type_id' => $type_ids[0]
        ]);

        DB::table('products')->insert([
            'productname' => 'Chili Mix',
            'description' => 'feurig-scharf',
            'brand_id' => $brand_ids[1],
            'type_id' => $type_ids[0]
        ]);

        DB::table('products')->insert([
            'productname' => 'Silber Zwiebeln',
            'description' => 'knackig - mild',
            'brand_id' => $brand_ids[2],
            'type_id' => $type_ids[2]
        ]);

        DB::table('products')->insert([
            'productname' => 'Knoblauch',
            'description' => 'mild & fein',
            'brand_id' => $brand_ids[2],
            'type_id' => $type_ids[2]
        ]);
    }
}
