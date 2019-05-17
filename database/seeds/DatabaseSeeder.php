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
        $this->call(OrganisationsTableSeeder::class);

        $this->call(TypesTableSeeder::class);

        $this->call(TagsTableSeeder::class);
        
        /* Alte Migrationen */
        // $this->call(SizesTableSeeder::class);
        // $this->call(ProductHasSizesTableSeeder::class);
        // $this->call(ProductsTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
    }
}
