<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(string $type='default')
    {
        if($type == 'demo'){
            $demo_region = ['Region I', 'Region II', 'Region III'];
            foreach($demo_region as $region){
                $curr_reg = DB::table('regions')->where('region',$region)->first();
                Group::factory()->create([
                    'region_id' => $curr_reg->id,
                ]); 
            }
    
        }else{
            $regions = json_decode(DB::table('regions')->get(),true);
            foreach($regions as $region){
                $num_of_groups = rand(1,2);
                Group::factory()->count($num_of_groups)->create([
                    'region_id' => $region['id'],
                ]);   
            }
    
        }
    }
}
