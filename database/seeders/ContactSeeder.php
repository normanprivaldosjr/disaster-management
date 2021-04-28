<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Contact;
use App\Models\Region;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(string $type='default')
    {
        $regions = json_decode(DB::table('regions')->get(),true);
        $name_contacts = ['Red Cross', 'Cost Guard'];
        $num_of_contacts = rand(1,4);
        foreach($regions as $region){
            if($type=='demo'){
                foreach($name_contacts as $name){
                    Contact::factory()->create([
                        'region_id' => $region['id'],
                        'rescuers' => $name.' '.$region['region'],
                    ]);
                }
            }
            else{
                Contact::factory()->count($num_of_contacts)->create([
                    'region_id' => $region['id'],
                ]);   
    
            }

        }

    }
}
