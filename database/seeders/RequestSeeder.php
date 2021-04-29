<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Request;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')->count();
        $statuses = DB::table('statuses')->count();
        $sources = DB::table('sources')->count();
        $groups = DB::table('groups')->count();
       
        for ($x = 0; $x < 200; $x++) {

            $status = rand(1, $statuses);
            if($status==1){
                $user_id = NULL;
            }
            else{
                $user_id = rand(1,$users);
            }

            Request::factory()->create([
                'user_id' => $user_id,
                'status_id' => $status,
                'source_id' => rand(1, $sources),
                'group_id' => rand(1, $groups),
                'creator_id' => rand(1, $users),
            ]);
        }

        foreach (Request::all() as $request) {
            $priorities = Priority::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $request->priorities()->attach($priorities);
        }
    }
}
