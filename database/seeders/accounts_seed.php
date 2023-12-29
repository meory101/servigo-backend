<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class accounts_seed extends Seeder
{

    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('SuperAdmin1'),
            'roleid' => 4

        ]);
        DB::table('users')->insert([
            'name' => 'Mediator',
            'email' => 'mediator@gmail.com',
            'password' => Hash::make('Mediator1'),
            'roleid' => 3

        ]);
    }
}
