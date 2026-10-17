# Panduan & Design Tokens HotelOps untuk Figma

Dokumen ini adalah panduan lengkap untuk merekonstruksi, menghubungkan, dan meng-upgrade antarmuka **HotelOps** ke dalam **Figma**.

---

## 🚀 2 Cara Menghubungkan & Mengimpor UI Web ke Figma

### Cara 1: Menggunakan Ekstensi Browser "html.to.design" (Paling Cepat & 100% Akurat)
Ekstensi ini dapat meng-capture tampilan website lokal (`http://127.0.0.1:8000`) dan langsung mengubahnya menjadi elemen Auto-Layout Figma yang bisa diedit (*editable vectors & texts*):

1. **Install Plugin di Figma:**
   - Di aplikasi/web Figma, buka file project baru.
   - Klik menu **Plugins** -> cari **`html.to.design`** -> klik **Run**.
2. **Install Ekstensi Chrome/Edge:**
   - Pasang ekstensi **html.to.design** dari [Chrome Web Store](https://chromewebstore.google.com/detail/htmltodesign/pmgcllhfkpjhinkbgfcglhfgpnkclhed).
3. **Capture Halaman Web:**
   - Buka browser ke **http://127.0.0.1:8000** (pastikan server aktif).
   - Klik ikon ekstensi **html.to.design** di pojok kanan atas browser.
   - Klik tombol **"Import to Figma"** (atau simpan sebagai file `.h2d`).
4. **Buka di Figma:**
   - Seluruh denah kamar bento, kartu pastel, font Fredoka, dan inspektur profil langsung menjadi komponen Figma yang siap Anda upgrade!

---

### Cara 2: Direct URL Import via Public Tunnel (Opsional)
Jika Anda ingin plugin Figma menarik URL secara langsung tanpa ekstensi:
Jalankan perintah tunnel di terminal proyek:
```bash
npx localtunnel --port 8000
```
Salin link HTTPS yang dihasilkan (misal `https://hotelops-demo.loca.lt`), lalu masukkan ke dalam kolom URL di plugin **html.to.design** atau **Builder.io** di Figma.

---

## 🎨 Token Desain HotelOps untuk Figma (Variables & Styles)

Buatlah **Figma Variables** atau **Color Styles** berikut agar desain baru Anda selaras dengan kode sistem:

### 1. Color Styles (Warna & Surface)

| Nama Style di Figma | Hex Code | Deskripsi & Penggunaan |
| :--- | :--- | :--- |
| **Surface / Frame-Outer** | `#E8B49B` | Bingkai terluar bernuansa dusty peach / terracotta |
| **Surface / Canvas-Main** | `#FAF6EE` | Kanvas latar belakang utama (Warm Ivory) |
| **Surface / Card-White** | `#FFFFFF` | Permukaan kartu utama bento & tabel |
| **Surface / Border-Warm** | `#ECE4D5` | Garis tepi halus antar-komponen |
| **Brand / Charcoal-Dark** | `#18181B` | Tombol utama, lencana mikro, teks judul gelap |
| **Bento / Peach-Kotor** | `#FDE8CF` | Kartu kamar kotor & housekeeping |
| **Bento / Blue-Tersedia** | `#D4E5F9` | Kartu kamar bersih & tersedia untuk dipesan |
| **Bento / Coral-Terisi** | `#FDD8D5` | Kartu kamar terisi tamu menginap |
| **Bento / Lavender-Total** | `#E3D6F8` | Kartu metrik total kamar hotel |
| **Bento / Mint-Okupansi** | `#D6F5E8` | Kartu metrik tingkat okupansi hari ini |
| **Bento / Sand-Perawatan** | `#FAE8D8` | Kartu kamar dalam pemeliharaan/perbaikan |

---

### 2. Typography Styles (Font Pairing di Figma)

Pastikan Anda telah mengaktifkan atau mengunduh Google Fonts berikut di Figma:
1. **Fredoka** (Display Font): Digunakan untuk semua teks penting, judul, dan angka metrik bento.
2. **Montserrat** (UI & Body Font): Digunakan untuk data tabel, teks deskripsi, input form, dan badge status.

| Text Style di Figma | Font Family | Weight | Size | Line Height | Penggunaan |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Display / Hero-Number** | `Fredoka` | Bold (700) | 36px | 44px | Angka metrik di kartu bento pastel |
| **Heading / H1-Page** | `Fredoka` | Bold (700) | 28px | 36px | Judul utama halaman (Operasional Kamar) |
| **Heading / H2-Section** | `Fredoka` | Bold (700) | 18px | 24px | Judul seksi (Ringkasan, Denah Kamar) |
| **Heading / H3-Card** | `Fredoka` | Bold (700) | 16px | 22px | Nama tamu di profil inspektur & modal |
| **Body / Regular** | `Montserrat` | Medium (500) | 13px | 18px | Nilai data tabel, form input |
| **Body / Semibold** | `Montserrat` | SemiBold (600) | 13px | 18px | Sub-item, label form |
| **Caption / Muted** | `Montserrat` | Medium (500) | 11px | 14px | Sublabel, tanggal, teks abu-abu |
| **Badge / Status-Pill** | `Montserrat` | ExtraBold (800) | 10px | 12px | Tag status kamar (Tersedia, Terisi, Kotor) |

---

### 3. Corner Radius Tokens (Border Radius)

- **Outer App Container:** `36px` (`rounded-4xl`)
- **Card Bento Utama:** `24px` (`rounded-3xl`)
- **Tile Kamar Mini:** `16px` (`rounded-2xl`)
- **Button & Status Pill:** `9999px` (`rounded-full`)

---

### 4. Layout Grid Structure (Desktop 1440px)
- **Container Max-Width:** `1440px` (Center aligned)
- **Grid:** 12 Kolom (Gutter: `24px`)
  - **Left Section (8 Kolom):**
    - 6 Kotak Bento Metrik Pastel (Grid 3 Kolom x 2 Baris)
    - Denah Kamar Visual Interaktif (Grid 4 Kolom per lantai)
    - Baris Progress Kebersihan & Milestone
  - **Right Section (4 Kolom):**
    - Panel Inspektur Tamu / Kamar Aktif (Avatar lingkaran besar, nama, tombol aksi mikro melingkar, dan rincian transaksi)

---

## 💡 Ide Peningkatan UI (Upgrade Suggestions di Figma)

Ketika Anda meng-upgrade UI di Figma, berikut beberapa sentuhan visual yang dapat membuat tugas RPL Anda terlihat sangat menonjol di mata dosen penguji:

1. **Denah Kamar Isometrik / Mini Floorplan:**
   - Menambahkan ilustrasi mini furnitur kamar hotel (tempat tidur, lampu meja, jendela) di setiap tile kamar bento.
2. **Glassmorphism Subtle Highlights:**
   - Menambahkan highlight putih semi-transparan `15%` di bagian atas kartu pastel untuk efek kedalaman 3D (*subtle inner bevel*).
3. **Status Filter Switcher:**
   - Menambahkan tab segmented control di atas denah kamar: `[Semua] [Lantai 1] [Lantai 2] [Kamar Kotor Saja]`.
4. **Quick Booking Timeline / Gantt Chart View:**
   - Kalender horizontal mini di bawah denah kamar yang menunjukkan jadwal booking minggu ini.
