# Simple Ecommerce Web

Simple Ecommerce Web adalah aplikasi e-commerce sederhana berbasis **Laravel**, **Blade**, **Tailwind CSS**, **Alpine.js**, **PostgreSQL**, dan **Docker**. Project ini mendukung alur belanja dari katalog produk, cart, checkout, pembayaran Midtrans, sampai monitoring order oleh admin.

## Fitur Utama

### Customer
- Autentikasi user
- Homepage storefront dengan featured products
- Daftar produk dan filter kategori
- Detail produk
- Cart system
- Checkout flow
- Riwayat order
- Halaman pembayaran dengan **Midtrans Snap**

### Admin
- Dashboard admin
- CRUD produk
- CRUD kategori
- Monitoring pembayaran
- Approve pembayaran
- Update status order

## Arsitektur Singkat

Project ini menggunakan pola **Laravel MVC** dengan arsitektur server-rendered:

- **Routes**: mengatur endpoint public, customer, dan admin
- **Controllers**: menangani flow bisnis seperti cart, checkout, payment, dan admin management
- **Models (Eloquent)**: mengelola relasi data seperti product, category, cart, transaction, dan payment
- **Views (Blade)**: merender halaman storefront dan admin
- **Alpine.js**: untuk interaksi frontend ringan
- **Tailwind CSS**: untuk styling utility-first
- **Midtrans Snap**: untuk payment gateway

Alur utama aplikasi:

```text
User -> Product Catalog -> Cart -> Checkout -> Transaction -> Midtrans Payment -> Order History
                                              \-> Admin Verification / Order Management
```

## Struktur Fitur

### Public Storefront
- `/` → homepage
- `/products` → daftar produk
- `/products/{slug}` → detail produk

### Customer Area (auth)
- `/cart` → keranjang belanja
- `/checkout` → proses checkout
- `/orders` → riwayat order user
- `/payments/{transaction}` → pembayaran transaksi

### Admin Area (`/admin`)
- dashboard admin
- kelola produk
- kelola kategori
- daftar order
- approve payment
- update status order

## Tech Stack

- PHP / Laravel
- Blade Template Engine
- Tailwind CSS
- Alpine.js
- PostgreSQL
- Docker & Docker Compose
- Nginx
- Vite
- Midtrans Snap

## Relasi Domain Utama

Beberapa model inti di project ini:

- `User`
- `Product`
- `Category`
- `Cart`
- `CartItem`
- `Transaction`
- `TransactionItem`
- `Payment`

Relasi sederhananya:

```text
Category -> Products
User -> Cart -> CartItems -> Product
User -> Transactions -> TransactionItems -> Product
Transaction -> Payment
```

## Setup Environment

### 1. Clone repository

```bash
git clone <repository-url>
cd simple-ecommerce-web
```

### 2. Copy environment file

```bash
cp .env.example .env
```

### 3. Sesuaikan konfigurasi `.env`

Minimal sesuaikan bagian berikut:

```env
APP_NAME="Simple Ecommerce Web"
APP_URL=http://localhost:8088

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=simple_ecommerce_web
DB_USERNAME=postgres
DB_PASSWORD=postgres

FILESYSTEM_DISK=public

MIDTRANS_SERVER_KEY=your_midtrans_server_key
MIDTRANS_CLIENT_KEY=your_midtrans_client_key
MIDTRANS_IS_PRODUCTION=false
```

> Catatan: `.env.example` default Laravel masih memakai SQLite, jadi untuk menjalankan project ini dengan Docker/PostgreSQL Anda perlu mengubah konfigurasi database secara manual.

## Menjalankan Project dengan Docker

### 1. Build dan jalankan container

```bash
docker compose up -d --build
```

### 2. Install dependency backend

```bash
docker compose exec app composer install
```

### 3. Install dependency frontend

```bash
docker compose exec app npm install
```

### 4. Generate application key

```bash
docker compose exec app php artisan key:generate
```

### 5. Jalankan migration

```bash
docker compose exec app php artisan migrate
```

### 6. Buat symbolic link storage

```bash
docker compose exec app php artisan storage:link
```

### 7. Jalankan Vite dev server

```bash
docker compose exec app npm run dev
```

Project dapat diakses di:

- **App**: `http://localhost:8088`
- **PostgreSQL**: `localhost:5440`

## Docker Services

Konfigurasi `docker-compose.yml` saat ini menjalankan:

- `app` → container aplikasi Laravel
- `webserver` → Nginx pada port `8088`
- `db` → PostgreSQL pada port `5440`

## Payment Flow

Project ini memakai **Midtrans Snap** untuk checkout.

Flow singkatnya:

1. User menambahkan produk ke cart
2. User checkout
3. Sistem membuat `Transaction` dan `TransactionItem`
4. Sistem generate `snap_token` dari Midtrans
5. User diarahkan ke halaman payment
6. User menyelesaikan pembayaran melalui popup Snap
7. Status transaksi diperbarui sesuai flow aplikasi

File terkait payment:

- `config/midtrans.php`
- `app/Http/Controllers/CheckoutController.php`
- `app/Http/Controllers/PaymentController.php`
- `resources/views/payments/create.blade.php`

## Catatan Penting

- Pastikan key Midtrans di `.env` valid
- Saat development, Snap script memakai sandbox URL Midtrans
- Storage link diperlukan agar file upload / asset storage bisa diakses
- Beberapa halaman admin dan customer membutuhkan login
- Role `admin` diperlukan untuk mengakses `/admin`

## Perintah yang Sering Dipakai

```bash
docker compose up -d --build
docker compose exec app composer install
docker compose exec app npm install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan storage:link
docker compose exec app npm run dev
```

## Pengembangan Selanjutnya

Beberapa improvement yang bisa dilanjutkan:

- mobile navigation yang lebih kuat
- optimasi homepage untuk traffic dari social media
- pemisahan service layer untuk payment
- webhook / callback Midtrans yang lebih lengkap
- automated testing untuk cart, checkout, dan payment flow
- seed data produk dan kategori untuk demo

## Lisensi

Project ini mengikuti lisensi default dari framework Laravel kecuali ditentukan lain oleh pemilik repository.