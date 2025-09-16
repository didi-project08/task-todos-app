<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $positions = [
            ['name' => 'Manager'],
            ['name' => 'Supervisor'],
            ['name' => 'Staff'],
            ['name' => 'Developer'],
            ['name' => 'Designer']
        ];

        foreach ($positions as $position) {
            DB::table('positions')->insert([
                'id' => Str::uuid(),
                'name' => $position['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}