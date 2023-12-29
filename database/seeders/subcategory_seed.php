<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class subcategory_seed extends Seeder
{
    
    public function run(): void
    {
        DB::table('subcategory')->insert([
            'name' => 'Flutter Development',
            'maincategoryid' => 1,
            
        ]);
        DB::table('subcategory')->insert([
            'name' => 'Web Development',
            'maincategoryid' => 1,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Firebase',
            'maincategoryid' => 1,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Laravel',
            'maincategoryid' => 1,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Voice over',
            'maincategoryid' => 2,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Song writer',
            'maincategoryid' => 2,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Logo design',
            'maincategoryid' => 3,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Website design',
            'maincategoryid' => 3,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Blog writing',
            'maincategoryid' => 4,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Artical writing',
            'maincategoryid' => 4,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'House keeping',
            'maincategoryid' => 5,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Deep cleaning',
            'maincategoryid' => 5,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Window cleaning',
            'maincategoryid' => 5,

        ]);
        DB::table('subcategory')->insert([
            'name' => 'Baby sitting',
            'maincategoryid' => 6,

        ]);
     
        
    }
}
