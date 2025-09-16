<p align="center"> <a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a> </p><p align="center"> <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a> </p>
Task Todo - Aplikasi Manajemen Tugas dengan Laravel 12

Aplikasi Task Todo adalah sistem manajemen tugas sederhana yang dibangun menggunakan Laravel 12 dan TailwindCSS. Aplikasi ini dirancang dengan konsep HMVC (Hierarchical Model-View-Controller) menggunakan folder Modules untuk semua logika bisnis yang terletak di app/Modules. 

Disclaimer
    
    Aplikasi ini dibuat untuk memenuhi Tes Interview di PT. Apis Magnus Informatika.

Fitur Utama 

     Autentikasi Pengguna: Halaman login dan register
     Manajemen Tugas: 
         Membuat tugas baru
         Melihat daftar tugas
         Mengedit tugas
         Menghapus tugas
     Profil:
         Update data pengguna
         
     Arsitektur HMVC: Logika bisnis terorganisir dalam modul terpisah
     

Prasyarat 

     PHP >= 8.2
     Composer
     Node.js v22.19.0 
     PostgreSQL
     Git
     

Instalasi 

    Clone Repositori 
    git clone https://github.com/didi-project08/task-todos-app.git
    cd task-todos-app

    step 1
    composer install
    step 2
    npm install
 
Konfigurasi Environment 

    Salin file .env.example ke .env: 
    cp .env.example .env

Generate application key

    php artisan key:generate
 
Konfigurasi Database PostgreSQL 

    Buka file .env dan atur konfigurasi database PostgreSQL: 

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=nama_database_anda
    DB_USERNAME=nama_user_postgres
    DB_PASSWORD=password_postgres_anda
 
Jalankan Migration dan Seeder 

    Buat database PostgreSQL terlebih dahulu, kemudian jalankan: 
    php artisan migrate
    php artisan db:seed
 
Build Asset 

    Kompilasi asset TailwindCSS: 
    npm run dev atau
    npm run build
 
Jalankan Server 

    php artisan serve
    
    Aplikasi akan berjalan di http://localhost:8000

    Login Default
    email: admin@example.com
    password: Admin123

Struktur Aplikasi 

    Aplikasi ini menggunakan konsep HMVC dengan semua logika bisnis ditempatkan di
    dalam folder app/Modules: 

    app/
    └── Modules/
        ├── Auth/
        │   ├── Controllers/
        │   ├── Models/
        │   ├── Views/
        │   └── router.php
        └── TaskTodo/
            ├── Controllers/
            ├── Models/
            ├── Views/
            └── router.php
    
    untuk audit log ada di

    storage/
    └── logs/
        └── audit-xxxx-xx-xx.log

Penjelasan Modul: 

    Modul Auth: Menangani autentikasi pengguna (login dan register)
    Modul TaskTodo: Menangani semua fungsi terkait manajemen tugas
     

Cara Penggunaan 

    Registrasi Akun: 
        Kunjungi halaman /auth/register
        Isi formulir registrasi dengan email dan password
         
    Login: 
        Kunjungi halaman /auth/login
        Masukkan email dan password yang telah didaftarkan

    Profil:
        Kunjungi halaman /profile
        Klik bagian nama di header sebelah tombol logout
        sekarang anda bisa mengupdate profil dan ubah password

    Manajemen Tugas:
         Kunjungi halaman /task-todos
         Setelah login, Anda akan diarahkan ke halaman managemen tugas
         Buat tugas baru dengan mengklik tombol "Tambah Tugas Baru"

         - FITUR UTAMA -
         Pencarian
         Filter
         Table Daftar semua tugas Anda
         Lihat detail tugas Anda
         Edit tugas dengan mengklik ikon edit
         Hapus tugas dengan mengklik ikon hapus

Catatan Penting 

     Semua logika bisnis terkait task ditempatkan di dalam folder App/Modules
     Desain antarmuka menggunakan TailwindCSS dengan komponen yang telah dikonfigurasi
     
Lisensi 

Aplikasi ini dilisensikan di bawah MIT License. 

Dikembangkan dengan ❤️ menggunakan Laravel 12 dan TailwindCSS 