<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sources = ['Facebook','Twitter','SMS','Others'];
        foreach($sources as $source){
            DB::table('sources')->insert(['source' => $source]);

        }

    }
}
