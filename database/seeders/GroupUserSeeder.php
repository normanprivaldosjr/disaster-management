<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\User;


class GroupUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')->count();
        $groups = json_decode(DB::table('groups')->get(),true);
        foreach($groups as $group){
            $num = rand(1,5);
            for ($x = 0; $x < $num; $x++) {
                $user_id = rand(1,$users);
                $group_id = rand(1, count($groups));
                $duplicate = DB::table('group_user')
                ->where('group_id',$group_id)
                ->where('user_id',$user_id)
                ->count();
                if($duplicate==0){
                    DB::table('group_user')->insert([
                        'user_id' => $user_id,
                        'group_id' => $group_id,
                        'creator' => (bool)rand(0, 1)
                    ]);
                }
            }
        }
    }
}
