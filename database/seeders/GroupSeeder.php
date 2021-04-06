<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = json_decode(DB::table('regions')->get(),true);
        foreach($regions as $region){
            $num_of_groups = rand(1,2);

            $group = Group::factory()->count($num_of_groups)->create([
                'region_id' => $region['id'],
            ]);   
        }
    }
}
