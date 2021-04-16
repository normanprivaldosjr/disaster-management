<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorities = ['Pregnant', 'Senior Citizen', 'Child', 'PWD', 'Sick'];

        foreach ($priorities as $priority) {
            Priority::create(['name' => $priority]);
        }
    }
}
