<p align="center"> <a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a> </p><p align="center"> <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a> </p>
Task Todo - Aplikasi Manajemen Tugas dengan Laravel 12 

Aplikasi Task Todo adalah sistem manajemen tugas sederhana yang dibangun menggunakan Laravel 12 dan TailwindCSS. Aplikasi ini dirancang dengan konsep HMVC (Hierarchical Model-View-Controller) menggunakan folder Modules untuk semua logika bisnis yang terletak di app/Modules. 
Fitur Utama 

     Autentikasi Pengguna: Halaman login dan register
     Manajemen Task: 
         Membuat tugas baru
         Melihat daftar tugas
         Mengedit tugas
         Menghapus tugas
         Menandai tugas sebagai selesai/belum selesai
         
     Arsitektur HMVC: Logika bisnis terorganisir dalam modul terpisah
     

Prasyarat 

     PHP >= 8.2
     Composer
     Node.js dan npm
     PostgreSQL
     Git
     

Instalasi 
1. Clone Repositori 
bash
 
 
 
1
2
git clone https://github.com/username/task-todo.git
cd task-todo
 
 
 
2. Instal Dependensi PHP 
bash
 
 
 
1
composer install
 
 
 
3. Instal Dependensi JavaScript 
bash
 
 
 
1
npm install
 
 
 
4. Konfigurasi Environment 

Salin file .env.example ke .env: 
bash
 
 
 
1
cp .env.example .env
 
 
 

Generate application key: 
bash
 
 
 
1
php artisan key:generate
 
 
 
5. Konfigurasi Database PostgreSQL 

Buka file .env dan atur konfigurasi database PostgreSQL: 
env
 
 
 
1
2
3
4
5
6
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nama_database_anda
DB_USERNAME=nama_user_postgres
DB_PASSWORD=password_postgres_anda
 
 
 
6. Jalankan Migration dan Seeder 

Buat database PostgreSQL terlebih dahulu, kemudian jalankan: 
bash
 
 
 
1
2
php artisan migrate
php artisan db:seed
 
 
 
7. Build Asset 

Kompilasi asset TailwindCSS: 
bash
 
 
 
1
npm run build
 
 
 
8. Jalankan Server 
bash
 
 
 
1
php artisan serve
 
 
 

Aplikasi akan berjalan di http://localhost:8000 
Struktur Aplikasi 

Aplikasi ini menggunakan konsep HMVC dengan semua logika bisnis ditempatkan di dalam folder app/Modules: 
 
 
 
1
2
3
4
5
6
7
8
9
10
11
12
app/
└── Modules/
    ├── Auth/
    │   ├── Controllers/
    │   ├── Models/
    │   ├── Requests/
    │   └── Routes/
    └── Task/
        ├── Controllers/
        ├── Models/
        ├── Requests/
        └── Routes/
 
 
 
Penjelasan Modul: 

     Modul Auth: Menangani autentikasi pengguna (login dan register)
     Modul Task: Menangani semua fungsi terkait manajemen tugas
     

Cara Penggunaan 

     

    Registrasi Akun: 
         Kunjungi halaman /register
         Isi formulir registrasi dengan email dan password
         
     

    Login: 
         Kunjungi halaman /login
         Masukkan email dan password yang telah didaftarkan
         
     

    Manajemen Task: 
         Setelah login, Anda akan diarahkan ke halaman dashboard
         Buat tugas baru dengan mengklik tombol "Tambah Tugas"
         Lihat daftar semua tugas Anda
         Edit tugas dengan mengklik ikon edit
         Hapus tugas dengan mengklik ikon hapus
         Tandai tugas sebagai selesai dengan mengklik checkbox
         
     

Catatan Penting 

     Aplikasi ini tidak memiliki fitur manajemen user (hanya registrasi dan login dasar)
     Semua logika bisnis terkait task ditempatkan di dalam Modul Task
     Desain antarmuka menggunakan TailwindCSS dengan komponen yang telah dikonfigurasi
     

Kontribusi 

Jika Anda ingin berkontribusi pada pengembangan aplikasi ini, silakan: 

     Fork repositori
     Buat branch fitur baru (git checkout -b fitur-baru)
     Commit perubahan Anda (git commit -am 'Menambah fitur baru')
     Push ke branch (git push origin fitur-baru)
     Buat Pull Request
     

Lisensi 

Aplikasi ini dilisensikan di bawah MIT License. 

Dikembangkan dengan ❤️ menggunakan Laravel 12 dan TailwindCSS 