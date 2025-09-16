<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        // User default admin
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('Admin123'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $users = [
            [
                'name' => 'Ahmad Santoso',
                'email' => 'ahmad.santoso@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti.rahayu@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Budi Pratama',
                'email' => 'budi.pratama@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Dewi Anggraini',
                'email' => 'dewi.anggraini@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko.widodo@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Rina Wijaya',
                'email' => 'rina.wijaya@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Agus Setiawan',
                'email' => 'agus.setiawan@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Hendra Gunawan',
                'email' => 'hendra.gunawan@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Lina Kusuma',
                'email' => 'lina.kusuma@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Password123'),
                'remember_token' => Str::random(10),
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'id' => Str::uuid(),
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => $user['email_verified_at'],
                'password' => $user['password'],
                'remember_token' => $user['remember_token'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}