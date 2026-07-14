# ✦ MerchPopRika — K-pop Photocard Marketplace

Aplikasi web marketplace jual-beli photocard, album, dan merch K-pop antar fans. Dibangun dengan **Laravel 11** (PHP), Blade + TailwindCSS (CDN), Chart.js untuk analytics, dan database SQLite/MySQL.

## Fitur Utama

- **Autentikasi**: Register (pilih role Pembeli/Penjual) & Login
- **3 Role**: Admin, Penjual (pemilik toko photocard), Pembeli
- **Pembeli**: jelajahi photocard dari berbagai toko, keranjang belanja (badge jumlah item otomatis update), checkout, **bill/struk pesanan** (bisa dicetak/simpan sebagai PDF lewat browser), riwayat pesanan, beri ulasan toko
- **Penjual**: buat profil toko, CRUD photocard (dengan upload gambar, kategori album/grup, dan **kondisi/grade: Mint, Near Mint, Good, Sealed**), kelola pesanan masuk & update status, **dashboard dengan grafik pendapatan 7 hari terakhir**
- **Admin**: dashboard statistik platform + **grafik tren pendapatan**, kelola pengguna, kelola toko (aktif/nonaktifkan), lihat semua pesanan
- Tema **pastel pink-lavender dengan aksen holographic** — kesan fresh & girly ala dunia fandom K-pop, dengan font display Baloo 2

## Struktur Database

- `users` (role: admin/seller/buyer)
- `stores` (toko milik seller)
- `photo_cards` (photocard/merch milik toko, termasuk field kondisi/grade)
- `orders` (header pesanan pembeli)
- `order_items` (rincian item per pesanan)
- `reviews` (ulasan toko dari pembeli)

## Cara Menjalankan (di laptop kamu)

> **Catatan**: folder `vendor/` sengaja tidak disertakan (praktik standar Laravel). Jalankan `composer install` sekali untuk menarik framework Laravel-nya.

1. **Extract** file zip ini, lalu masuk ke foldernya lewat terminal.

2. **Install dependency PHP**:
   ```bash
   composer install
   ```

3. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

4. **Setup database**:

   **Opsi A — SQLite (paling gampang, tinggal buat file kosong):**
   ```bash
   touch database/database.sqlite
   ```

   **Opsi B — MySQL:**
   Edit file `.env`, uncomment & sesuaikan baris berikut (comment baris `DB_CONNECTION=sqlite`):
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=merchpoprika
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Lalu buat database kosong bernama `merchpoprika` di phpMyAdmin/MySQL Workbench.

5. **Migrasi + isi data contoh**:
   ```bash
   php artisan migrate --seed
   ```

6. **Buat symlink storage** (supaya gambar photocard yang diupload bisa tampil):
   ```bash
   php artisan storage:link
   ```

7. **Jalankan server**:
   ```bash
   php artisan serve
   ```
   Buka `http://localhost:8000` di browser.

## Akun Contoh (hasil seeding)

| Role   | Email                     | Password   |
|--------|----------------------------|------------|
| Admin  | admin@merchpoprika.test    | password   |
| Seller | seller1@merchpoprika.test  | password   |
| Seller | seller2@merchpoprika.test  | password   |
| Buyer  | buyer@merchpoprika.test    | password   |

Atau langsung daftar akun baru lewat halaman **Register** (pilih role Pembeli/Penjual).

## Alur Coba Aplikasi (untuk video presentasi)

1. Login sebagai **buyer** → jelajahi photocard di beranda → buka detail photocard → tambah ke keranjang (perhatikan badge angka di ikon keranjang navbar otomatis nambah)
2. Buka **Keranjang** → Checkout → isi alamat & metode bayar → buat pesanan
3. Otomatis diarahkan ke halaman **bill/struk pesanan** → coba klik "Cetak / Simpan PDF"
4. Cek **Pesanan Saya** untuk lihat riwayat
5. Login sebagai **seller** → lihat **Dashboard Toko** (dengan grafik pendapatan) → **Kelola Photocard** (tambah/edit/hapus, pilih kondisi Mint/Near Mint/Good/Sealed) → **Pesanan Masuk** → update status pesanan jadi "Completed"
6. Balik login sebagai buyer, buka pesanan yang sudah "Completed" → beri ulasan toko
7. Login sebagai **admin** → lihat statistik & grafik tren pendapatan platform, kelola pengguna & toko

## Tech Stack

- Backend: Laravel 11 (PHP 8.2+)
- Frontend: Blade Templates + TailwindCSS (via CDN, tanpa build step) + Chart.js untuk grafik
- Database: SQLite (default) / MySQL
- Auth: Laravel built-in session auth (custom, role-based middleware)

---

## 🚀 Deploy ke Railway (Opsional — untuk poin bonus)

Repo ini sudah menyertakan `nixpacks.toml` dan `Procfile` supaya proses build & start otomatis terdeteksi Railway.

### Langkah singkat:
1. Push folder ini ke repo GitHub.
2. Di [railway.app](https://railway.app), login dengan GitHub → **New Project** → **Deploy from GitHub repo** → pilih repo ini.
3. Tambahkan database: **+ New** → **Database** → **Add MySQL**.
4. Di service Laravel, buka tab **Variables**, isi minimal:
   - `APP_KEY` — ambil dari hasil `php artisan key:generate --show` di laptop kamu
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `DB_CONNECTION=mysql`
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` — isi pakai reference variable ke service MySQL yang baru dibuat (Railway biasanya punya tombol "Add Reference Variable")
5. Railway otomatis build ulang. Setelah sukses, klik **Settings** → **Generate Domain** untuk dapat link publik.
6. Cantumkan link tersebut di PRD dan video presentasi kamu.

`Procfile` di repo ini sudah diset untuk otomatis menjalankan `php artisan migrate --force` setiap deploy, jadi database selalu sinkron dengan migration terbaru.
