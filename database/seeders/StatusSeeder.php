<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['New','Ongoing','Contacted: Waiting for Rescue','Cannot be reached','Safe: No need for Rescue','Rescued','Need Supplies','Safe'];
        
        foreach($statuses as $status){
            DB::table('statuses')->insert([
                'status' => $status,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

        }
    }
}
