<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\serviceType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  
    public function run(): void
    {
        $this->call([
            role_seed::class,

        ]);
        $this->call([
            servicetype_seed::class,

        ]);
        $this->call([
            maincategory_seed::class,

        ]);
        $this->call([
            subcategory_seed::class,

        ]);
        $this->call([
            accounts_seed::class,

        ]);

    }
}
