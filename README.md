<p align="center">
  <img src="public/images/logo-icon.png" width="100" alt="Mamacare Logo">
</p>
<h1 align="center">Mamacare V2 🤰✨</h1>

<p align="center">
  Mamacare adalah aplikasi asisten kehamilan cerdas berbasis web yang didesain secara khusus dengan pendekatan UI/UX bergaya <strong>Neo-Brutalism</strong> yang ceria, tebal, dan ramah pengguna (Mobile-First). Platform ini menghubungkan ibu hamil (Mama) dengan tenaga medis profesional (Dokter & Bidan).
</p>

---

## 🌟 Fitur Utama

Aplikasi ini dibagi menjadi 3 peran (*role*) pengguna utama: **Mama**, **Dokter**, dan **Admin**.

### 👩‍🍼 Fitur Khusus Mama
- **Chat Mama AI:** Asisten cerdas berbasis Artificial Intelligence (menggunakan Google Gemini API) untuk menjawab keluhan kehamilan secara *real-time*.
- **AI Food Scanner (Scanner Gizi):** Memungkinkan mama mengunggah foto makanan dan membiarkan AI menganalisis kandungan gizi serta keamanannya bagi kehamilan.
- **Tanya Dokter (Live Chat):** Konsultasi langsung dengan dokter spesialis atau bidan yang terdaftar.
- **Reservasi Medis:** Membuat janji temu untuk pemeriksaan kehamilan secara *offline*.
- **Ukuran Janin:** Panduan visual interaktif yang menyamakan ukuran janin setiap minggu dengan buah-buahan (misal: "Sebesar alpukat di minggu ke-16!").
- **Pantau Berat Badan:** Grafik *weight tracker* cerdas untuk memantau kenaikan berat badan ideal selama kehamilan berdasarkan *Body Mass Index* (BMI).
- **Penghitung Tendangan (Kick Counter):** Alat sederhana untuk menghitung frekuensi tendangan bayi dalam rentang waktu 2 jam.
- **Penghitung Kontraksi (Contraction Timer):** Fitur kronometer untuk mengukur durasi dan interval kontraksi menjelang persalinan.
- **Panduan Nutrisi:** Direktori makanan rekomendasi dan pantangan (berdasarkan Trimester) yang dikurasi langsung oleh dokter.
- **Kalender Kehamilan & Rekap Medis:** Mencatat HPM, usia kehamilan, dan menyimpan semua hasil diagnosis dokter.

### 👩‍⚕️ Fitur Khusus Dokter
- **Manajemen Artikel Kesehatan:** Sistem CMS penuh (*Create, Read, Update, Delete*) bagi dokter untuk menulis dan menerbitkan artikel edukasi kehamilan.
- **Manajemen Panduan Nutrisi:** Dokter dapat merekomendasikan atau melarang suatu jenis makanan dan gizi berdasarkan usia trimester kehamilan.
- **Manajemen Pasien & Reservasi:** Mengelola jadwal janji temu, menulis catatan rekam medis (diagnosis & resep obat).
- **Jawab Chat Pasien:** Berkomunikasi membalas keluhan dari para Mama.

### 🛠️ Fitur Admin
- **Kelola Pengguna:** Menambah, memverifikasi, dan menghapus akun pengguna (Dokter & Mama).
- **Dasbor Analitik:** Memantau aktivitas platform secara menyeluruh.

---

## 🎨 Design System (Neo-Brutalism)
Mamacare mengadopsi gaya visual yang sangat berani:
- **Warna Utama:** Pink Terang (`#FF3EA5`, `#ff47a1`), Pink Gelap (`#C21B75`), dan Putih.
- **Bentuk:** Sudut sangat bulat (`rounded-3xl`), garis pinggir tebal (`border-2`), dan bayangan blok tebal (*solid drop shadows* `shadow-[4px_4px_0px_0px_#ff90c8]`).
- **Interaksi:** Mikro-animasi saat ditekan (`active:translate-y-1 active:shadow-none`), memberikan sensasi memencet tombol fisik (sangat memuaskan!).
- **Framework:** TailwindCSS terintegrasi via Vite, dengan elemen interaktif ditenagai oleh Alpine.js.

---

## 🚀 Instalasi & Cara Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan Mamacare secara lokal di komputer Anda:

1. **Clone repositori ini:**
   ```bash
   git clone https://github.com/Azmi-Student/MamacareV2.git
   cd mamacare
   ```

2. **Install Dependensi PHP & Node.js:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment:**
   Salin file konfigurasi lalu sesuaikan kredensial database (contohnya MySQL/MariaDB melalui Laragon/XAMPP).
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   > ⚠️ **Penting:** Pastikan Anda menambahkan API Key Gemini di `.env` agar fitur AI Scanner & Chat AI berfungsi.
   > ```env
   > GEMINI_API_KEY="AIzaSyYourApiKeyHere..."
   > ```

4. **Migrasi dan Seeder Database:**
   Perintah ini akan membuat semua struktur tabel dan mengisi data awal (dummy users, artikel, dan panduan nutrisi).
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Aplikasi:**
   Buka dua jendela terminal untuk menjalankan backend server dan compiler aset frontend.
   ```bash
   php artisan serve
   ```
   ```bash
   npm run dev
   ```

6. Buka browser dan akses `http://localhost:8000`.

---

## 🔐 Akun Dummy (Seeder)
Untuk masuk dan mencoba fitur aplikasi, gunakan akun bawaan berikut (Password untuk semua akun adalah: `password`):
- **Admin:** `admin@gmail.com`
- **Dokter:** `dokter@gmail.com` (Dr. Boyke) / `aisah@gmail.com` (Dr. Aisah)
- **Mama:** `mama@gmail.com` (Bunda Jule)

---
*Dibuat dengan penuh cinta untuk kesehatan Ibu dan Anak. 👶💕*
