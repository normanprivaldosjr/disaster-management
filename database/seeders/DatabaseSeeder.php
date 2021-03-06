<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            RegionSeeder::class,
            GroupSeeder::class,
            StatusSeeder::class,
            SourceSeeder::class,
            ContactSeeder::class,
            PrioritySeeder::class,
            RequestSeeder::class,
            GroupUserSeeder::class,
        ]);
    }
}
