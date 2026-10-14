# Desain Sistem & Panduan UI/UX HotelOps
> **Gaya Desain:** *Warm Ivory Pastel Bento (Bento UI with Luxury Hotel Aesthetics)*  
> **Referensi Visual:** Berdasarkan referensi desain pada [design-reference.png](file:///d:/Tugas%20semester%203/RPL/tubes%20lagi/design-reference.png).

---

## 1. Filosofi & Karakteristik Desain

Gaya desain ini mengadopsi konsep **Pastel Bento Warm-Minimalism** yang memadukan kehangatan estetika hotel butik modern dengan keteraturan tata letak *Bento Grid*.

```
+-----------------------------------------------------------------------------------------+
|  FRAME LUAR (Terracotta / Warm Peach Frame: #e8b49b)                                   |
|  +-----------------------------------------------------------------------------------+  |
|  |  CANVAS UTAMA (Warm Ivory / Cream Parchment: #faf6ee)                            |  |
|  |  [Logo]       [Tab: Denah Kamar] [Buku Tamu] [Reservasi]       (Icons) [Avatar]   |  |
|  |  -------------------------------------------------------------------------------  |  |
|  |  Judul Halaman              [Pill Tamu 1: Dewi L.]  [Pill Tamu 2: Ahmad F.]       |  |
|  |                                                                                   |  |
|  |  +-- KOLOM UTAMA BENTO (70%) ---------------+ +-- INSPECTOR KANAN (30%) --------+ |  |
|  |  | [6 Kartu Metrik Pastel Berwarna]         | | [Kartu Profil Tamu / Kamar]     | |  |
|  |  |  - Tersedia (Peach)  - Terisi (Blue)     | |   - Avatar Lingkaran Besar      | |  |
|  |  |  - Kotor (Lavender)  - Perawatan (Coral) | |   - Nama & Peran / Status       | |  |
|  |  |  - Pendapatan (Mint) - Tamu Hari Ini     | |   - Baris Tombol Aksi Bulat     | |  |
|  |  |                                          | |                                 | |  |
|  |  | [Bento Denah Kamar & Jadwal Reservasi]   | | [Kartu Rincian Informasi]       | |  |
|  |  |  - Grid Kamar Bersudut Membulat         | |   - Nomor Kamar, NIK, No HP     | |  |
|  |  |  - Indikator Warna Status Real-time      | |   - Subtotal & Tombol Kasir     | |  |
|  |  +------------------------------------------+ +---------------------------------+ |  |
|  +-----------------------------------------------------------------------------------+  |
+-----------------------------------------------------------------------------------------+
```

### Elemen Visual Kunci:
1. **Outer Frame & Canvas:** Latar belakang dibungkus bingkai hangat bernuansa *terracotta / dusty peach*, dengan kanvas utama berwarna *warm ivory / cream*.
2. **Super-Rounded Corners (`rounded-2xl` & `rounded-3xl`):** Semua kartu, tombol, dan wadah memiliki kelengkungan sudut tinggi (16px – 28px) untuk memberikan impresi lembut, modern, dan ramah sentuhan (*touch-friendly*).
3. **Pastel Color-Block Bento Tiles:** Kartu ringkasan metrik menggunakan warna-warna pastel tematik (peach, soft blue, lavender, blush coral, mint sage) dengan tipografi kontras tinggi.
4. **Dark High-Contrast Micro-Badges:** Judul seksi dan tombol tindakan mikro menggunakan lingkaran hitam *matte charcoal* (`#18181b`) dengan ikon putih tajam.
5. **Two-Column Asymmetric Layout:** Bagian kiri menampilkan ikhtisar bento dan data operasional, sementara bagian kanan berfungsi sebagai *Detail Inspector Panel* (profil tamu atau kamar aktif yang sedang dipilih).

---

## 2. Palet Warna & Token Desain (Color Tokens)

### 2.1. Warna Latar & Kanvas (Surfaces)
| Token Nama | Hex Code | Penggunaan |
| :--- | :--- | :--- |
| **Frame Background** | `#e8b49b` | Bingkai terluar pembungkus aplikasi (browser wrapper) |
| **Canvas Background** | `#faf6ee` | Kanvas latar belakang utama dashboard |
| **Card White Surface** | `#ffffff` | Permukaan kartu utama bento & tabel |
| **Card Subtle Cream** | `#f5efe4` | Latar kartu sekunder / tab bar tidak aktif |
| **Border Soft** | `#ece4d5` | Garis tepi halus antar-komponen |

### 2.2. Warna Kartu Metrik Pastel (Bento Accent Tiles)
| Nama Kartu | Latar Pastel | Warna Border | Warna Teks / Angka | Penggunaan di HotelOps |
| :--- | :--- | :--- | :--- | :--- |
| **Pastel Peach / Amber** | `#fde8cf` | `#f6caa2` | `#7c2d12` | Kamar Kotor / Menunggu Cleaning |
| **Pastel Sky Blue** | `#d4e5f9` | `#b6d4f6` | `#1e40af` | Kamar Tersedia & Bersih |
| **Pastel Lavender** | `#e3d6f8` | `#cdbaf4` | `#5b21b6` | Total Pendapatan Hari Ini |
| **Pastel Blush / Coral** | `#fdd8d5` | `#f8b4ae` | `#991b1b` | Kamar Terisi (Occupied) |
| **Pastel Mint / Sage** | `#d6f5e8` | `#a9ebd0` | `#065f46` | Tamu Selesai Check-in |
| **Pastel Warm Sand** | `#fae8d8` | `#f0caa9` | `#854d0e` | Kamar Masa Perawatan |

### 2.3. Tipografi & Kontras Tinggi (Typography & Badges)
| Token Nama | Hex Code | Penggunaan |
| :--- | :--- | :--- |
| **Dark Badge / Charcoal** | `#18181b` | Lingkaran ikon seksi, tombol utama, pill gelap |
| **Text Primary** | `#1c1917` | Judul, angka metrik utama, nama tamu |
| **Text Secondary** | `#78716c` | Subtitle, label deskripsi, keterangan tanggal |
| **Text Muted** | `#a8a29e` | Placeholder, tanggal lampau, pembatas |

---

## 3. Tipografi & Hierarki Font (Font Pairing: Fredoka & Montserrat)

Gaya visual ini memadukan **Fredoka** (font display cartoon membulat nan ramah) untuk elemen-elemen penting penarik atensi (*important text & headings*) dengan **Montserrat** (font sans-serif geometris modern) untuk teks isi dan data operasional yang membutuhkan keterbacaan tinggi.

- **Display & Important Text Font Family:** `Fredoka` (Google Fonts, Rounded Cartoon Display).
  - Digunakan pada:
    - Judul Halaman Utama (`h1`, `Operasional Kamar & Tamu`, `HotelOps`)
    - Judul Seksi Bento (`h2`, `Ringkasan Operasional Kamar`, `Denah Kamar Visual`, dll.)
    - Angka Metrik Utama Bento Hero (`text-3xl` / `text-4xl`, angka keterisian, kamar kotor, pendapatan)
    - Nomor Kamar & Identitas Badge (`No. 101`, `#101`)
    - Nama Tamu pada Panel Profil Inspektur & Modal Dialog
- **Body & Interface Font Family:** `Montserrat` (Google Fonts, Geometric Sans-Serif).
  - Digunakan pada:
    - Teks deskripsi & pengantar modul
    - Tabel data operasional, riwayat transaksi, buku tamu
    - Form input, placeholder, tombol navigasi, pill status
- **Scale Hierarki:**
  - **Hero Number (Angka Metrik Bento):** `font-cartoon` `text-3xl` s/d `text-4xl` (`font-bold`).
  - **Page Title (`h1`):** `font-cartoon` `text-2xl` s/d `text-3xl` (`font-bold`, `tracking-tight`).
  - **Section Title (`h2`):** `font-cartoon` `text-lg` s/d `text-xl` (`font-bold`).
  - **Card / Modal Title (`h3`):** `font-cartoon` `text-base` s/d `text-lg` (`font-bold`).
  - **Body / Table Value:** `font-sans` `text-xs` s/d `text-sm` (`font-medium` / `font-semibold`).
  - **Caption / Meta Sublabel:** `font-sans` `text-[10px]` s/d `text-[11px]` (`font-medium`, text-secondary).
  - **Status Pill Tag:** `font-sans` `text-[10px]` s/d `text-xs` (`font-extrabold`, uppercase / sentence case).

---

## 4. Anatomi Komponen UI (Component Blueprint)

### 4.1. Header & Navigation Tab Bar
- **Brand Area (Kiri):**
  - Ikon cincin / hotel geometris di dalam lingkaran hitam.
  - Teks brand: **HotelOps** (`font-bold`, `tracking-tight`).
- **Pill Navigation Tabs (Tengah):**
  - Kapsul horizontal dengan item menu:
    - *Tab Aktif:* Berlatar putih bersih (`#ffffff`), bayangan lembut (`shadow-sm`), sudut membulat penuh (`rounded-full`), teks hitam tebal.
    - *Tab Tidak Aktif:* Transparan / berlatar krem halus, teks abu-abu hangat, efek hover lembut.
- **Micro Actions & Avatar (Kanan):**
  - Tombol-tombol lingkaran kecil berikon (Home, Cari, Notifikasi Lonceng).
  - Foto avatar lingkaran pengguna dengan border putih tipis dan badge peran.

### 4.2. Sub-Header (Quick Status Pill Bar)
- Menampilkan judul konteks modul di sebelah kiri: `"Informasi Tamu & Kamar"`.
- Di sebelah kanan terdapat deretan kartu kecil horizontal (*chips*) berisi tamu VIP / kamar yang baru saja check-in dengan foto mini, nama, dan pill persentase/status (misal: `Dewi Lestari [Kamar 201]`, `Ahmad Fauzi [Check-out]`).

### 4.3. Bento Metrics Grid (6 Kotak Pastel)
- Disusun dalam grid 3 kolom x 2 baris (atau 2 kolom x 3 baris pada tablet).
- Setiap kotak memiliki:
  1. Ikon kategori di kiri atas di dalam lingkaran semi-transparan.
  2. Tombol panah diagonal / expand di kanan atas.
  3. Angka metrik berukuran besar di tengah.
  4. Keterangan perbandingan tren di bawahnya (`+15% hari ini`, `Siap Ditempati`).

### 4.4. Lower Bento Modules
- **Bento Kiri Bawah (Denah Kamar Visual):**
  - Kartu-kartu kamar berbentuk bento mini bersudut bulat (`rounded-2xl`).
  - Indikator warna kamar terisi (merah pastel), bersih (biru pastel), dan kotor (kuning/peach pastel).
- **Bento Kanan Bawah (Progress Pembersihan & Milestone):**
  - Batang progres bertahap dengan dua warna (persentase kebersihan kamar hotel hari ini).
  - Daftar tugas kamar dengan pill kategori: `[Cleaning]`, `[Check-In Tamu]`, `[Perawatan AC]`.

### 4.5. Inspector Sidebar (Kolom Kanan)
- **Kartu Profil Utama:**
  - Avatar lingkaran besar di bagian atas kartu putih melengkung.
  - Nama tamu / nomor kamar dalam teks tebal hitam.
  - Subtitel: NIK dan status menginap.
  - Baris aksi mikro melingkar: Tombol Edit (pensil), Kirim Tagihan (email), Telepon, Tambah Layanan, Kuitansi.
- **Kartu Informasi Rincian (Detailed Information):**
  - Baris-baris data bersih dengan ikon abu-abu:
    - *Nomor Kamar* & Tipe
    - *Tanggal Check-in & Check-out*
    - *Total Tagihan & Status Lunas*
    - *Metode Pembayaran Terpilih*
  - Tombol aksi utama check-in atau check-out di bagian bawah.

---

## 5. Pemetaan Tampilan Berdasarkan Peran di HotelOps

| Modul | Implementasi Gaya Desain Referensi |
| :--- | :--- |
| **Resepsionis** | - 6 Kartu Bento: Kamar Tersedia (Biru), Terisi (Merah), Kotor (Peach), Perawatan (Sand), Pendapatan (Lavender), Booking Aktif (Mint).<br>- Denah Kamar Bento di kolom kiri.<br>- Inspector Tamu di kolom kanan untuk aksi cepat Check-In, Check-Out, dan Kasir. |
| **Petugas Kebersihan** | - Papan tugas kamar kotor menggunakan kartu bento pastel peach.<br>- Tombol melingkar hitam "Tandai Bersih" dengan ikon centang.<br>- Bar progres persentase kebersihan seluruh lantai hotel. |
| **Manajer** | - Modul analitik okupansi dengan slider dan perbandingan target vs aktual.<br>- Tabel master kamar dan pengguna staf dengan sudut membulat mewah dan baris zebra krem lembut.<br>- Halaman cetak laporan tetap ramah printer (*clean black & white print mode*). |

---

## 6. Konfigurasi Tailwind CSS (Design Implementation Specs)

Untuk menerapkan gaya visual ini secara presisi pada project Laravel Blade, konfigurasi Tailwind CSS adalah sebagai berikut:

```javascript
// tailwind.config.js / script inline
tailwind.config = {
  theme: {
    extend: {
      colors: {
        canvas: {
          frame: '#e8b49b',       // Bingkai luar peach
          bg: '#faf6ee',          // Kanvas utama warm ivory
          card: '#ffffff',        // Permukaan kartu putih
          subtle: '#f5efe4',      // Krem halus
          border: '#ece4d5',      // Border hangat
        },
        bento: {
          peach: { bg: '#fde8cf', border: '#f6caa2', text: '#7c2d12' },
          blue: { bg: '#d4e5f9', border: '#b6d4f6', text: '#1e40af' },
          lavender: { bg: '#e3d6f8', border: '#cdbaf4', text: '#5b21b6' },
          coral: { bg: '#fdd8d5', border: '#f8b4ae', text: '#991b1b' },
          mint: { bg: '#d6f5e8', border: '#a9ebd0', text: '#065f46' },
          sand: { bg: '#fae8d8', border: '#f0caa9', text: '#854d0e' },
          dark: '#18181b',
        }
      },
      borderRadius: {
        '2xl': '1rem',
        '3xl': '1.5rem',
        '4xl': '2rem',
      },
      fontFamily: {
        sans: ['Montserrat', 'sans-serif'],
      }
    }
  }
}
```

---

## 7. Rencana Langkah Integrasi ke Aplikasi HotelOps

1. **Update `layouts/app.blade.php`:**
   - Menyertakan Google Font *Montserrat*.
   - Menerapkan wrapper bingkai terluar `#e8b49b` dengan kanvas tengah `#faf6ee`.
   - Mengubah navbar menjadi bilah tab kapsul (*pill tab bar*) dengan ikon mikro melingkar.
2. **Transformasi `resepsionis/dashboard.blade.php`:**
   - Menyusun 6 bento metric cards berwarna pastel di kolom kiri.
   - Mengubah kartu kamar visual menjadi tiles bento dengan ikon expand.
   - Menambahkan *Inspector Sidebar* di kolom kanan untuk detail tamu / kamar terpilih.
3. **Transformasi `kebersihan/index.blade.php`:**
   - Mengadopsi bento task cards dengan progress bar bertingkat.
4. **Transformasi Halaman Login `auth/login.blade.php`:**
   - Kartu login hangat dengan sudut melengkung 3xl, pill demo login bernuansa pastel bento.
