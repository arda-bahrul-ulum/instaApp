# InstaApp

InstaApp adalah aplikasi media sosial sederhana yang terinspirasi dari Instagram, dibangun menggunakan Laravel, Inertia.js, dan Vue 3. Aplikasi ini memungkinkan pengguna untuk mendaftar, login, membuat postingan dengan gambar, mengedit/menghapus postingan sendiri, mencari postingan, serta mengelola profil. UI/UX didesain modern dan responsif dengan nuansa dark mode dan elemen visual mirip Instagram.

## Tech Stack

-   **Backend:** Laravel 12
-   **Frontend:** Vue 3 (Single Page Application via Inertia.js)
-   **Styling:** Tailwind CSS
-   **Bundler:** Vite
-   **Database:** MySQL
-   **Authentication:** Laravel Breeze (Inertia + Vue)

## Library & Tools

-   [Inertia.js](https://inertiajs.com/) — SPA bridge antara Laravel & Vue
-   [Vue 3](https://vuejs.org/) — Frontend framework
-   [Tailwind CSS](https://tailwindcss.com/) — Utility-first CSS framework
-   [vue-toastification](https://github.com/Maronato/vue-toastification) — Toast notification
-   [Laravel Breeze](https://laravel.com/docs/10.x/starter-kits#breeze-and-inertia) — Auth scaffolding
-   [Vite](https://vitejs.dev/) — Frontend build tool

## Fitur Utama

-   **Register, Login, Logout**
-   **CRUD Postingan** (dengan upload & preview gambar)
-   **Edit & Delete Post (hanya milik sendiri)**
-   **Konfirmasi sebelum delete (modal)**
-   **Search Post (real-time, mirip Instagram)**
-   **Profile Management** (edit profil, delete akun)
-   **Toast notification untuk aksi penting**
-   **UI/UX modern, dark mode, responsive**
-   **Akses postingan hanya milik user login di menu Post**
-   **Halaman kosong khusus jika belum ada postingan**

## Instalasi & Setup

### 1. Clone Repository

```bash
git clone <repo-url>
cd instaApp
```

### 2. Install Dependency Backend (Laravel)

```bash
composer install
```

### 3. Install Dependency Frontend (Node.js)

```bash
npm install
```

### 4. Copy & Edit Environment

```bash
cp .env.example .env
# Edit .env sesuai konfigurasi database & mail
```

### 5. Generate Key & Jalankan Migration

```bash
php artisan key:generate
php artisan migrate
```

### 6. Storage Link (untuk upload gambar)

```bash
php artisan storage:link
```

### 7. Jalankan Development Server

-   Backend (Laravel):

```bash
php artisan serve
```

-   Frontend (Vite):

```bash
npm run dev
```

Akses aplikasi di [http://localhost:8000](http://localhost:8000) (atau sesuai port yang tampil).

## Struktur Folder Penting

-   `app/Http/Controllers/` — Controller Laravel
-   `resources/js/Pages/` — Halaman Vue (SPA)
-   `resources/js/Components/` — Komponen Vue
-   `routes/` — File route Laravel
-   `public/` — Aset publik
-   `storage/app/public/` — Upload gambar

## Catatan

-   Hanya user yang login yang bisa melihat, mengedit, dan menghapus postingan miliknya sendiri di menu Post.
-   Dashboard (Home) menampilkan semua postingan (feed).
-   Semua aksi penting (register, login, CRUD post, delete akun) menampilkan toast notification.
-   Tidak ada Blade view kecuali root Inertia (SPA full).

## Kontribusi

Pull request & issue sangat diterima! Silakan fork dan kembangkan fitur sesuai kebutuhan.

---

**InstaApp** — Modern Instagram-like SPA with Laravel + Inertia + Vue 3
