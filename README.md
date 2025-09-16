<p align="center"> <a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a> </p><p align="center"> <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a> </p>
Tentang Aplikasi Task Todo

Task Todo adalah aplikasi manajemen tugas yang dibangun dengan Laravel 12 dan TailwindCSS. Aplikasi ini menggunakan arsitektur HMVC (Hierarchical Model-View-Controller) yang memisahkan logika bisnis ke dalam modul-modul terpisah untuk memudahkan pengembangan dan pemeliharaan.

Fitur utama yang tersedia:

    Manajemen tugas lengkap (CRUD operations)

    Antarmuka responsif dengan TailwindCSS

    Autentikasi pengguna

    Arsitektur HMVC dengan struktur Modules

    Database PostgreSQL

🛠️ Instalasi
Prerequisites

Pastikan software berikut telah terinstall di sistem Anda:

    PHP 8.1 atau lebih baru

    Composer

    Node.js dan npm

    PostgreSQL

    Web server (Apache/Nginx)

Langkah-langkah Instalasi

    Clone Repository
    bash

git clone <repository-url>
cd task-todo

Install Dependencies PHP
bash

composer install

Install Dependencies JavaScript
bash

npm install

Konfigurasi Environment
bash

cp .env.example .env

Edit file .env dan sesuaikan konfigurasi database PostgreSQL:
env

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nama_database_anda
DB_USERNAME=username_database_anda
DB_PASSWORD=password_database_anda

Generate Application Key
bash

php artisan key:generate

Jalankan Migration dan Seeder
bash

php artisan migrate --seed

Build Assets CSS/JavaScript
bash

npm run build

Untuk development:
bash

npm run dev

Jalankan Aplikasi
bash

php artisan serve

    Aplikasi akan berjalan di http://localhost:8000

🏗️ Struktur HMVC

Aplikasi ini menggunakan arsitektur HMVC dengan struktur sebagai berikut:
text

app/
└── Modules/
    ├── Task/
    │   ├── Controllers/
    │   ├── Models/
    │   ├── Views/
    │   ├── Routes/
    │   └── Services/
    └── User/
        ├── Controllers/
        ├── Models/
        ├── Views/
        ├── Routes/
        └── Services/

Setiap modul memiliki fungsionalitas yang independen dan dapat dikembangkan secara terpisah, memanfaatkan fitur Laravel Packages untuk organisasi kode yang lebih baik.
📦 Modul yang Tersedia

    Task Module - Mengelola CRUD operations untuk tugas menggunakan Laravel Eloquent

    User Module - Mengelola autentikasi dan profil pengguna dengan Laravel Authentication

🗃️ Database

Aplikasi menggunakan PostgreSQL dengan struktur tabel yang diatur melalui Laravel Migrations:

    users - menyimpan data pengguna

    tasks - menyimpan data tugas

    (tambahkan tabel lain jika ada)

🎨 Frontend

TailwindCSS digunakan untuk styling, dengan komponen yang responsif dan modern.
📝 Penggunaan

    Akses aplikasi melalui browser

    Daftar atau login sebagai pengguna

    Buat tugas baru melalui form yang tersedia

    Kelola tugas (edit, tandai selesai, hapus)

🧪 Testing

Jalankan test suite dengan perintah:
bash

php artisan test

📊 Maintenance

Untuk optimalisasi autoload:
bash

composer dump-autoload

Untuk clear cache:
bash

php artisan optimize:clear

🤝 Kontribusi

Thank you for considering contributing to the Task Todo Application! The contribution guide can be found in the Laravel documentation.
Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the Code of Conduct.
Security Vulnerabilities

If you discover a security vulnerability within our application, please send an e-mail to the development team via [email address]. All security vulnerabilities will be promptly addressed.
License

The Task Todo Application is open-sourced software licensed under the MIT license.

Catatan: Pastikan PostgreSQL sudah berjalan sebelum menjalankan migration dan seeder.