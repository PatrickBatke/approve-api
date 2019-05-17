<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organisation_ids = DB::table('organisations')->pluck('id')->toArray();
        $type_ids = DB::table('types')->pluck('id')->toArray();

        DB::table('projects')->insert([
            'init_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'title' => 'Maxi-Markt Website',
            'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam 
            nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. 
            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea 
            takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur 
            sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
             erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita 
             kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
            'organisation_id' => $organisation_ids[0],
            'type_id' => $type_ids[2],
            'manager' => 'Franjo',
            'picture' => '..\assets\images\projectpics\mypartystartseite.jpg'
        ]);

        DB::table('projects')->insert([
            'init_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'title' => 'Maxi-Markt Folder',
            'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam 
            nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. 
            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea 
            takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur 
            sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam
             erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita 
             kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
            'organisation_id' => $organisation_ids[0],
            'type_id' => $type_ids[0],
            'manager' => 'Manager',
            'picture' => '..\assets\images\projectpics\maximarktt.jpg'
        ]);
    }
}
