# SIMKEB — Sistem Manajemen Kebijakan

Project Laravel 11 lengkap. Siap dijalankan setelah `composer install`.

---

## Cara Instalasi

### 1. Extract zip & masuk folder

```bash
unzip simkeb-laravel-complete.zip
cd simkeb
```

### 2. Install dependensi PHP

```bash
composer install
```

### 3. Salin file environment

```bash
cp .env.example .env
```

### 4. Generate app key

```bash
php artisan key:generate
```

### 5. Setup database

**Opsi A — SQLite (paling cepat):**

File `.env` sudah default ke SQLite, tinggal buat filenya:

```bash
touch database/database.sqlite
```

**Opsi B — MySQL:**

Edit `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simkeb
DB_USERNAME=root
DB_PASSWORD=
```
Lalu buat databasenya: `CREATE DATABASE simkeb;`

### 6. Jalankan migration + seeder

```bash
php artisan migrate --seed
```

### 7. Link storage (untuk upload file)

```bash
php artisan storage:link
```

### 8. Jalankan server

```bash
php artisan serve
```

Buka: **http://localhost:8000**

---

## Akun Default

| Email | Password | Role | Status |
|-------|----------|------|--------|
| raguel@telkomuniversity.ac.id | password | Super Admin | Aktif |
| siti.a@univ.edu | password | Admin BPA | Pending |
| andi.w@univ.edu | password | Admin Fakultas | Aktif |

---

## Daftarkan Middleware (sudah ada di bootstrap/app.php)

Middleware sudah terdaftar di `bootstrap/app.php`:

```php
$middleware->alias([
    'user.active' => \App\Http\Middleware\EnsureUserIsActive::class,
    'super.admin' => \App\Http\Middleware\EnsureSuperAdmin::class,
]);
```

Tidak perlu konfigurasi tambahan.

---

## Alur Sistem

```
Daftar (Register) → Status: Pending
        ↓
Super Admin approve di halaman Admin
        ↓
Status: Aktif → Bisa login
```

---

## Struktur Folder Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── DokumenController.php
│   │   ├── AdminController.php
│   │   └── ProsesBisnisController.php
│   └── Middleware/
│       ├── EnsureUserIsActive.php
│       └── EnsureSuperAdmin.php
├── Models/
│   ├── User.php
│   ├── Dokumen.php
│   └── ProsesBisnis.php
bootstrap/
├── app.php          ← Middleware alias terdaftar di sini
config/
├── app.php, auth.php, database.php, session.php, ...
database/
├── migrations/      ← 6 file (3 default Laravel + 3 SIMKEB)
└── seeders/DatabaseSeeder.php
resources/views/
├── auth/            ← login, register, forgot-password
├── layouts/app.blade.php
├── dashboard.blade.php
├── dokumen/
├── admin/
└── proses-bisnis/
routes/
├── web.php
└── console.php
```

---

## Catatan

- **Lupa Password** belum kirim email asli. Untuk produksi gunakan `Password::sendResetLink()`.
- **Upload file dokumen** disimpan di `storage/app/public/dokumen/`. Pastikan `php artisan storage:link` sudah dijalankan.
- Untuk production: set `APP_ENV=production` dan `APP_DEBUG=false` di `.env`.
