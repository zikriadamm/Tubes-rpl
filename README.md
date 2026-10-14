# HotelOps — Sistem Informasi Manajemen Meja Depan Hotel

> **Tugas Besar Rekayasa Perangkat Lunak (RPL) - Semester 3**  
> Sistem Manajemen Operasional Hotel (*Property Management System / Front Desk System*) berbasis **Laravel 10**, **Blade**, **Tailwind CSS**, dan **Alpine.js**.

---

## 🌟 Fitur Utama

1. **Denah Kamar Visual Interaktif (Bento Grid Layout):**
   - Monitoring status kamar real-time: *Tersedia*, *Terisi*, *Kotor*, dan *Perawatan*.
   - Panel inspektur interaktif di sisi kanan untuk melihat rincian tamu, kamar, dan tindakan cepat.

2. **Otomatisasi Sinkronisasi Status Kamar:**
   - **Check-In:** Mengubah status kamar menjadi **Terisi**.
   - **Check-Out & Kasir:** Menghitung total tagihan, nominal pembayaran tunai/transfer/QRIS, serta kembalian secara otomatis, lalu mengubah status kamar menjadi **Kotor**.
   - **Housekeeping:** Petugas kebersihan memverifikasi dan menandai kamar selesai dibersihkan, sehingga otomatis kembali menjadi **Tersedia & Bersih**.

3. **Otorisasi Hak Akses Berbasis Peran (RBAC):**
   - **Resepsionis:** Registrasi buku tamu, pembuatan reservasi kamar, check-in tamu, kasir pembayaran & cetak kuitansi.
   - **Petugas Kebersihan (Housekeeping):** Papan tugas antrean kamar kotor dan verifikasi kamar bersih.
   - **Manajer Hotel:** Kontrol penuh master data kamar (CRUD), manajemen akun staf, serta akses ke seluruh laporan.

4. **Tiga Format Laporan Manajerial & Cetak:**
   - **Laporan Okupansi Harian:** Analisis tingkat keterisian unit hotel per hari.
   - **Laporan Pendapatan Bulanan:** Rekapitulasi transaksi penerimaan kas (Tunai, Bank, QRIS).
   - **Laporan Riwayat Tamu Menginap:** Catatan histori durasi dan kamar yang pernah disewa.
   - **Kuitansi Resmi:** Tampilan siap cetak (*print-friendly*) untuk bukti pembayaran sah tamu.

5. **Desain Sistem & Tipografi:**
   - **Gaya:** *Warm Ivory Pastel Bento* terinspirasi estetika hotel butik modern.
   - **Font Pairing:** **Fredoka** (Google Font rounded cartoon display untuk judul dan angka penting) dipadukan dengan **Montserrat** (geometric sans-serif untuk keterbacaan data).

---

## 🚀 Panduan Menjalankan Sistem Lokal

### 1. Kebutuhan Sistem (Prerequisites)
- PHP >= 8.1 dengan ekstensi `pdo_sqlite` atau `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`.
- Composer
- Web browser modern

### 2. Instalasi & Setup

```bash
# 1. Clone repositori
git clone <URL_REPO_GITHUB_ANDA>
cd "tubes lagi"

# 2. Salin environment file
cp .env.example .env

# 3. Instal dependensi Composer (jika belum ada folder vendor)
composer install

# 4. Generate Application Key
php artisan key:generate

# 5. Jalankan migrasi dan seeder database
touch database/database.sqlite
php artisan migrate:fresh --seed

# 6. Jalankan server lokal
php artisan serve
```

Aplikasi dapat diakses melalui browser di: **http://127.0.0.1:8000**

---

## 🔑 Akun Demo Pengujian

Aplikasi dilengkapi tombol **1-Klik Demo Login** pada halaman login untuk memudahkan pengujian oleh dosen/penguji:

| Peran (Role) | Email | Kata Sandi | Akses Modul |
| :--- | :--- | :--- | :--- |
| **Manajer Hotel** | `manajer@hotel.com` | `password` | Master Kamar, Manajemen Staf, Seluruh Laporan |
| **Resepsionis** | `resepsionis@hotel.com` | `password` | Denah Kamar, Reservasi, Buku Tamu, Kasir Check-out |
| **Petugas Kebersihan** | `kebersihan@hotel.com` | `password` | Papan Tugas Housekeeping & Verifikasi Bersih |

---

## 🧪 Pengujian Otomatis (Automated Testing)

Sistem telah diuji dengan pengujian fitur otomatis (Feature Tests) menggunakan PHPUnit:

```bash
php vendor/bin/phpunit
```

**Hasil Pengujian:**
- 11 Tests, 25 Assertions: **100% Pass** (Mencakup pengujian keunikan nomor kamar, validasi tarif > 0, proteksi RBAC, transaksi kasir, dan alur siklus hidup operasional kamar).

---

## 📄 Dokumen Terkait
- [design.md](design.md): Panduan Desain Sistem & Token UI/UX Bento.
- [PLAN_SISTEM_HOTEL_OPERASIONAL.md](PLAN_SISTEM_HOTEL_OPERASIONAL.md): Perencanaan dan spesifikasi kebutuhan fungsional sistem.
