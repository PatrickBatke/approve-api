<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganisationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organisations')->insert([
            'name' => 'Maxi Markt',
            'address' => 'Bäckermühlweg 61',
            'zipcode' => '4030',
            'city' => 'Linz/Wegscheid',
            'country' => 'Austria',
            'phone' => '+43-xxx',
            'mail' => 'office@maximarkt.at'
        ]);
    }
}
