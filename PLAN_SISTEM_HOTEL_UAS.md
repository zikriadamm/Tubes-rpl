# PLAN PROJEK RPL (UAS) - TEMA HOTEL
## Sistem Manajemen & Reservasi Hotel (Hotel Management System)

### 1. IDENTITAS PROJEK
- Nama usulan: **StayEase Hotel / Inapin / HotelKu**
- Tagline: "Pesan Kamar Hotel Jadi Mudah, Cepat & Nyaman"
- Deskripsi: Sistem web terintegrasi untuk pencarian kamar, reservasi online, manajemen check-in/out, hingga laporan keuangan. Solusi untuk masalah pencatatan manual & double-booking.
- Jenis: Web Application (Responsive)
- SDLC untuk Laporan: **Waterfall** (Requirement -> Design -> Implementation -> Testing -> Maintenance) -> Paling aman untuk penilaian dosen RPL.

### 2. ROLE & HAK AKSES (ACTOR)
| Role | Hak Akses |
| :--- | :--- |
| **Tamu (Guest)** | Registrasi, login, cari & filter kamar, booking, bayar, lihat riwayat, rating/ulasan, batalkan |
| **Resepsionis** | Kelola check-in/out, lihat reservasi hari ini, update status kamar (Available/Booked/Occupied/Cleaning), input walk-in |
| **Admin/Manager** | Full: CRUD Kamar/Tipe/Fasilitas, Kelola User/Staff, Kelola Promo, Laporan Pendapatan & Okupansi, Export PDF/Excel |

### 3. FITUR LENGKAP

#### A. FITUR WAJIB (MVP - Nilai Utama UAS)
1. **Autentikasi:** Register, Login, Logout, Role-based Access
2. **Manajemen Kamar:** CRUD Kamar (No, Tipe: Standard/Deluxe/Suite, Harga, Kapasitas, Foto) + Fasilitas (AC/WiFi/dll) + Status Real-time
3. **Pencarian & Filter:** Filter tanggal, jumlah tamu, harga + Cek Ketersediaan Otomatis (Anti Double-Booking)
4. **Reservasi:** Keranjang, Hitung Total Otomatis (Harga x Malam + Pajak), Kode Booking Unik `HTL-xxxx`, Status (Pending->Confirmed->CheckedIn->CheckedOut->Cancelled)
5. **Check-In/Out:** Resepsionis ubah status + Generate Invoice
6. **Pembayaran (Simulasi):** Transfer/E-Wallet/Bayar di Tempat, Upload Bukti, Status Lunas/Pending. Nilai Plus: Midtrans Sandbox
7. **Dashboard & Laporan:** Dashboard Admin (Pendapatan, Kamar Terisi, Grafik), Laporan + Export PDF, Riwayat Booking Tamu

#### B. FITUR TAMBAHAN (Nilai A)
8. Rating & Ulasan (Bintang 1-5 setelah check-out)
9. Promo & Voucher (Kode HEMAT50)
10. Wishlist Kamar Favorit
11. Notifikasi Email (Mailtrap)
12. Layanan Tambahan (Laundry/Antar Jemput)
13. Chart Visual (Chart.js)

> Saran: Selesaikan 1-7 dulu -> Tambah 8 & 9 jika sempat.

### 4. TEKNOLOGI (Pilih 1)
| Opsi | Stack | Kelebihan |
| :--- | :--- | :--- |
| **1 (REKOMENDASI)** | **Laravel 11 + MySQL + Tailwind** | Paling mudah, dosen familiar, cepat jadi |
| 2 | Next.js 14 + Prisma + MySQL | Modern, nilai plus stack kekinian |
| 3 | Spring Boot + MySQL | Enterprise, jika dosen fokus Java |

### 5. DESAIN DATABASE (ERD) - 7 Tabel
- users(id, name, email, password, role)
- room_types(id, name, price_per_night, capacity, facilities)
- rooms(id, room_number, room_type_id, status, image)
- bookings(id, booking_code, user_id, room_id, check_in, check_out, total_price, status, payment_status)
- payments(id, booking_id, amount, method, proof_image, status)
- reviews(id, user_id, room_id, rating, comment)
- vouchers(id, code, discount_percent, valid_until)
Relasi: 1 RoomType -> Banyak Rooms | 1 User -> Banyak Bookings | 1 Booking -> 1 Payment

### 6. UML WAJIB UNTUK LAPORAN
1. Use Case Diagram (3 Actor + Fitur)
2. Activity Diagram (Alur Booking)
3. Sequence Diagram (Proses Check-In)
4. Class Diagram (dari ERD)
5. ERD
Tools: draw.io / Lucidchart / PlantUML (Gratis)

### 7. STRUKTUR LAPORAN UAS RPL
- BAB I Pendahuluan: Latar Belakang (masalah manual), Rumusan Masalah, Tujuan
- BAB II Landasan Teori: SDLC Waterfall, Konsep Reservasi Hotel, Teknologi, UML
- BAB III Analisis & Perancangan: Kebutuhan Fungsional/Non-Fungsional, UML, ERD, Desain UI (Figma)
- BAB IV Implementasi & Pengujian: Screenshot Aplikasi + Black Box Testing
- BAB V Penutup: Kesimpulan & Saran

### 8. HALAMAN UI YANG DIBUAT
1. Landing Page (Hero + Search Bar Tanggal)
2. Daftar Kamar (Card + Filter)
3. Detail Kamar (Galeri + Tombol Booking)
4. Halaman Booking & Pembayaran
5. Dashboard Tamu (Riwayat)
6. Dashboard Admin (Statistik + CRUD)

### 9. TIMELINE 4 MINGGU
| Minggu | Tugas | Output |
| :--- | :--- | :--- |
| 1 | Analisis & Desain | BAB I-III, UML, ERD, Wireframe |
| 2 | Backend | Database, Auth, CRUD Kamar |
| 3 | Frontend & Fitur Inti | Booking, Pembayaran, Check-in/out |
| 4 | Testing & Laporan | Black Box, Screenshot, PPT |

### 10. LANGKAH SELANJUTNYA - PILIH:
1. Mau saya buatkan Starter Project Laravel/Next.js sekarang?
2. Mau saya buatkan File Laporan DOCX + PPT?
3. Mau saya buatkan UML & ERD (gambar)?

> Jawab: Mau pakai Stack apa? (Laravel / Next.js / PHP Native) dan Berapa anggota kelompok?

