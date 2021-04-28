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
        $status = DB::table('statuses')->count();
        $sources = DB::table('sources')->count();
        $groups = DB::table('groups')->count();

        for ($x = 0; $x < 200; $x++) {
            Request::factory()->create([
                'user_id' => rand(1, $users),
                'status_id' => rand(1, $status),
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
