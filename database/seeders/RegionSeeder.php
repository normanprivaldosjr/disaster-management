<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $regions = ['NCR', 'CAR', 'Region I', 'Region II','Region III','Region IV-A','Mimaropa','Region V','Region VI', 'Region VII','Region VIII','Region IX','Region X','Region XI','Region XII','Region XIII','BARMM'];
        foreach($regions as $region){
            DB::table('regions')->insert(['region' => $region]);
        }
        //
    }
}
