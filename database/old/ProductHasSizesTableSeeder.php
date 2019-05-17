<?php

use Illuminate\Database\Seeder;

class ProductHasSizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size_ids = DB::table('sizes')->pluck('id')->toArray();
        $product_ids = DB::table('products')->pluck('id')->toArray();

        DB::table('product_has_sizes')->insert([
            'size_id' => $size_ids[0],
            'product_id' => $product_ids[0]
        ]);

        DB::table('product_has_sizes')->insert([
            'size_id' => $size_ids[0],
            'product_id' => $product_ids[0]
        ]);

        DB::table('product_has_sizes')->insert([
            'size_id' => $size_ids[0],
            'product_id' => $product_ids[0]
        ]);

        DB::table('product_has_sizes')->insert([
            'size_id' => $size_ids[0],
            'product_id' => $product_ids[0]
        ]);

        DB::table('product_has_sizes')->insert([
            'size_id' => $size_ids[0],
            'product_id' => $product_ids[0]
        ]);
    }
}
