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
    public function run()
    {
        $regions = json_decode(DB::table('regions')->get(),true);
        foreach($regions as $region){
            $num_of_contacts = rand(1,4);

            $contact = Contact::factory()->count($num_of_contacts)->create([
                'region_id' => $region['id'],
            ]);   
        }

    }
}
