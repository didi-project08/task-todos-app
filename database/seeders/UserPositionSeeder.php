<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserPositionSeeder extends Seeder
{
    public function run()
    {
        // Ambil beberapa user dan position untuk dibuat relasi
        $users = DB::table('users')->take(5)->get();
        $positions = DB::table('positions')->take(5)->get();

        foreach ($users as $index => $user) {
            if (isset($positions[$index])) {
                DB::table('user_positions')->insert([
                    'id' => Str::uuid(),
                    'user_id' => $user->id,
                    'position_id' => $positions[$index]->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}