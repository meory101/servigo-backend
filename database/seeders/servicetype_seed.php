<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class servicetype_seed extends Seeder
{
    
    public function run(): void
    {
        DB::table('servicetype')->insert([
            'name' => 'Technical services',
        ]);
        DB::table('servicetype')->insert([
            'name' => 'Human services',
        ]);
    }
}
