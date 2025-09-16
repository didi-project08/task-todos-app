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
        $users = DB::table('users')->get();

        $todos = [
            'Menyelesaikan laporan keuangan bulanan',
            'Mengerjakan presentasi untuk meeting client',
            'Memperbaiki bug pada aplikasi utama',
            'Melakukan testing pada fitur baru',
            'Mengupdate dokumentasi proyek',
            'Meeting dengan tim development',
            'Review kode untuk pull request',
            'Membuat design UI/UX untuk halaman baru',
            'Melakukan deploy ke production server',
            'Menganalisa data pengguna',
            'Membuat rencana marketing bulan depan',
            'Menyiapkan materi training untuk anggota baru',
            'Melakukan optimasi database',
            'Membuat backup data penting',
            'Merencanakan sprint berikutnya',
            'Mengikuti webinar teknologi terbaru',
            'Membuat konten untuk media sosial',
            'Melakukan maintenance server',
            'Mengembangkan API integration',
            'Mempelajari framework baru'
        ];

        foreach ($users as $user) {
            $numberOfTasks = rand(5, 15);
            
            for ($i = 0; $i < $numberOfTasks; $i++) {
                $startDate = Carbon::now()->subDays(rand(0, 30));
                $endDate = $startDate->copy()->addDays(rand(1, 14));
                
                DB::table('tasks')->insert([
                    'id' => Str::uuid(),
                    'user_id' => $user->id,
                    'todo' => $todos[array_rand($todos)],
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}