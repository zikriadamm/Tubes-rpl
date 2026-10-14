# Panduan & Walkthrough Tampilan Baru HotelOps (Warm Ivory Pastel Bento)

Seluruh antarmuka website **HotelOps** telah selesai di-redesign mengadopsi gaya visual referensi: **Warm Ivory Pastel Bento**.

---

## 1. Menjalankan Server Lokal

```powershell
& "C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe" artisan serve
```

Buka browser di: **`http://127.0.0.1:8000`**

---

## 2. Fitur Visual Baru yang Diterapkan

1. **Bingkai Luar & Kanvas Warm Ivory:** Frame luar terracotta (`#e8b49b`) dengan kontainer kanvas melengkung gading (`#faf6ee`) dan font modern *Plus Jakarta Sans*.
2. **Navigasi Kapsul (Pill Bar):** Tab menu horizontal dengan tab aktif berlatar putih bersih timbul.
3. **6 Kotak Bento Pastel:** Warna Peach (Kotor), Biru (Bersih/Tersedia), Lavender (Total), Coral (Terisi), Sand (Perawatan), dan Mint (Okupansi).
4. **Denah Kamar Interaktif + Inspector Sidebar:** Klik kamar mana saja di denah sebelah kiri, panel sebelah kanan akan otomatis menampilkan foto profil, rincian kamar, dan tombol aksi cepat (Check-in atau Check-out & Kasir).
5. **Tombol Aksi Melingkar & Milestones Progress Bar:** Slider progres kebersihan kamar hotel hari ini persis seperti pada gambar referensi.
6. **Halaman Login & Master Data:** Kartu berlekuk halus `rounded-4xl` dengan tombol akses cepat demo 1-klik pastel.
7. **Kuitansi & 3 Laporan:** Tetap rapi dan siap dicetak (*Print-Friendly Layout*).

---

## 3. Hasil Pengujian

Semua 9 tes fungsionalitas dan aturan bisnis telah diuji ulang dan **100% Lulus (Pass)**:
```powershell
& "C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe" artisan test --filter=HotelOperationsTest
```
