<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class maincategory_seed extends Seeder
{
    
    public function run(): void
    {
        DB::table('maincategory')->insert([
            'name' => 'Tech&&Development',
            'servicetypeid' => 1,
            'imageurl' => 'dev.jpg'
        ]);
        DB::table('maincategory')->insert([
            'name' => 'Music&&Audio',
            'servicetypeid' => 1,
            'imageurl' => 'voice.jpg'
        ]);

        DB::table('maincategory')->insert([
            'name' => 'Graphices&&Design',
            'servicetypeid' => 1,
            'imageurl' => 'gp.jpg'
        ]);
        DB::table('maincategory')->insert([
            'name' => 'Content writing',
            'servicetypeid' => 1,
            'imageurl' => 'content.jpg'
        ]);
        DB::table('maincategory')->insert([
            'name' => 'House services&&Cleaning',
            'servicetypeid' => 2,
            'imageurl' => 'house.jpg'
        ]);
        DB::table('maincategory')->insert([
            'name' => 'Child && family services',
            'servicetypeid' => 2,
            'imageurl' => 'fam.jpg'
        ]);
  
        
    }
}
