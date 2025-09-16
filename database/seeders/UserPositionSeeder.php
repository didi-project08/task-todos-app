<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserPositionSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->get();
        $positions = DB::table('positions')->get();

        if ($users->isEmpty() || $positions->isEmpty()) {
            $this->command->warn('Tidak ada data users atau positions. Seeder di-skip.');
            return;
        }

        $userPositions = [];

        foreach ($users as $user) {
            $randomPosition = $positions->random();
            
            $userPositions[] = [
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'position_id' => $randomPosition->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $chunks = array_chunk($userPositions, 100);
        foreach ($chunks as $chunk) {
            DB::table('user_positions')->insert($chunk);
        }

        $this->command->info('UserPositionSeeder berhasil: ' . count($userPositions) . ' relasi user-position dibuat.');
    }
}