<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class role_seed extends Seeder
{
   
    public function run(): void
    {
        DB::table('roles')->insert([
            'name' => 'seller',
        ]);
        DB::table('roles')->insert([
            'name' => 'buyer',
        ]);
        DB::table('roles')->insert([
            'name' => 'mediator',
        ]);
        DB::table('roles')->insert([
            'name' => 'admin',
        ]);


      
    }
}
