Project Name: Admin Panel with Login and CRUD for Posts and Categories
A. Penjelasan Project
Project ini adalah aplikasi web berbasis Laravel yang menyediakan fitur admin panel untuk mengelola data dari dua tabel yang memiliki relasi one-to-many. Tabel yang dikelola adalah posts data dan categories. Fitur login juga disertakan untuk membatasi akses ke admin panel.

Fitur Utama:
Login: Admin dapat login untuk mengelola data.
Manajemen Posts: CRUD (Create, Read, Update, Delete) untuk data posts.
Manajemen Categories: CRUD untuk data categories.
Pencarian: Fitur untuk mencari posts berdasarkan judul.
Relasi One-to-Many: Setiap post memiliki satu category, dan satu category bisa memiliki banyak posts.
Pattern MVC: Aplikasi mengikuti arsitektur Model-View-Controller (MVC).
Fully Responsive UI: Antarmuka yang responsif untuk pengalaman pengguna yang baik di perangkat apa pun.

B. Desain Database
Aplikasi ini menggunakan dua tabel utama:
Posts: Menyimpan data mengenai artikel atau konten yang di-input oleh pengguna.

id: Primary key
title: Judul post
content: Isi konten post
category_id: Foreign key yang menghubungkan dengan tabel categories
created_at: Timestamp ketika data dibuat
updated_at: Timestamp ketika data terakhir di-update

Categories: Menyimpan data kategori yang terkait dengan posts.
id: Primary key
name: Nama kategori
created_at: Timestamp ketika data dibuat
updated_at: Timestamp ketika data terakhir di-update


Relasi:
One-to-Many: Satu kategori bisa memiliki banyak post. Relasi ini diwakili oleh foreign key category_id di tabel posts.
ERD (Entity Relationship Diagram):


C. Screenshot Aplikasi
Berikut adalah beberapa screenshot dari aplikasi:

Login Page:
![alt text](/gambar/image.png)

Posts List:![alt text](/gambar/posts.png)

Create/Edit Post:![alt text](/gambar/createPosts.pngs)

Categories List:[alt text](/gambar/posts.png)

Create/Edit Category:![alt text](/gambar/createCategory.png)

(Ganti dengan path yang benar di repository)

D. Dependency
Project ini menggunakan beberapa dependency utama sebagai berikut:

Laravel Framework: v10.x (Framework PHP untuk membangun aplikasi web berbasis MVC)
Composer: Digunakan untuk mengelola dependency PHP.
MySQL: Digunakan sebagai database.
Breeze Authentication: Untuk mengelola login dan autentikasi pengguna.
Tailwind CSS: Untuk mengelola tampilan UI yang responsif.
Alpine.js: Untuk JavaScript frontend sederhana dalam mengelola UI.
XAMPP (opsional): Untuk server lokal PHP dan MySQL.

Cara Menginstal Dependency:
bash
Salin kode
# Install composer dependencies
composer install

# Jalankan migrasi untuk membuat tabel
php artisan migrate

# Jalankan server lokal
php artisan serve
E. Informasi Lain
Struktur Folder:
app/Http/Controllers: Berisi controller yang mengatur alur logika aplikasi (PostController, CategoryController, dll.).
app/Models: Berisi model untuk berinteraksi dengan database.
resources/views: Berisi file Blade untuk view halaman.
routes/web.php: Mengelola routing dan endpoint aplikasi.
Panduan Developer:
Menambahkan Fitur Baru: Untuk menambah fitur baru, ikuti pattern MVC yang sudah ada. Buat Controller, Model, dan View yang sesuai.
Migrations: Untuk menambah atau mengubah struktur tabel, gunakan migration dengan perintah php artisan make:migration.
Testing API: Gunakan Postman untuk menguji endpoint CRUD untuk posts dan categories.
Cara Menjalankan Aplikasi:
Clone repository ini:
bash
Salin kode
git clone <repository_url>
Install dependency dengan composer:
bash
Salin kode
composer install
Buat file .env dengan menyalin .env.example dan sesuaikan pengaturan database.
bash
Salin kode
cp .env.example .env
Generate application key:
bash
Salin kode
php artisan key:generate
Jalankan migration untuk membuat tabel:
bash
Salin kode
php artisan migrate
Jalankan aplikasi di server lokal:
bash
Salin kode
php artisan serve.