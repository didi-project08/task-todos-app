<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->take(3)->get();

        foreach ($users as $user) {
            DB::table('tasks')->insert([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'todo' => 'Mengerjakan tugas proyek ' . Str::random(5),
                'start_date' => Carbon::now()->subDays(rand(1, 10)),
                'end_date' => Carbon::now()->addDays(rand(5, 20)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}