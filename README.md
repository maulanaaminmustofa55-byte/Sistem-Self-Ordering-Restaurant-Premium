# Seafood Amin
Nama: Maulana Amin Mustofa NIM: 101230047 Kelas: TF23C

Sistem pemesanan dan kitchen display untuk restoran Seafood Amin berbasis PHP, MySQL, dan frontend responsif.

## Ringkasan Aplikasi
Aplikasi ini membantu restoran menerima pesanan pelanggan melalui QR Code meja, memproses pesanan di dapur, dan mengelola status pesanan secara real-time.

## Modul Utama
- Order Customer
  - Halaman pemesanan untuk pelanggan melalui QR Code meja
  - Pilihan menu, jumlah item, dan ringkasan pesanan
- Kitchen Display System (KDS)
  - Menampilkan pesanan aktif untuk tim dapur
  - Update status pesanan menjadi selesai
- QR Code Meja
  - Generate QR code untuk setiap meja
  - Memudahkan pelanggan membuka halaman pemesanan
- Data & Status Pesanan
  - Menyimpan pesanan ke database MySQL
  - Mengambil pesanan aktif dan mengubah status

## Fitur Utama
- Pemesanan menu secara online dari meja pelanggan
- Tampilan menu dengan detail harga, deskripsi, dan gambar
- Ringkasan pesanan real-time sebelum submit
- Monitor dapur otomatis untuk melihat antrian pesanan
- Fitur siap saji / selesai untuk memindahkan pesanan ke status selesai
- QR Code per meja untuk akses cepat
- UI modern dan responsif untuk desktop maupun mobile
- Login sederhana untuk akses KDS

## Stack Teknologi yang Digunakan
- Backend: PHP 8+
- Database: MySQL / MariaDB via mysqli
- Frontend: HTML5, CSS3, JavaScript (vanilla)
- UI Framework: Bootstrap 5
- Icons: Font Awesome 6
- Fonts: Playfair Display, Poppins
- QR Code: QR generator via API eksternal

## Struktur File Utama
- input_pesanan.php → halaman pemesanan pelanggan
- monitor_dapur.php → tampilan dapur / KDS
- get_data.php → API mengambil pesanan aktif
- update_status.php → API mengubah status pesanan
- generate_qr.php → generator QR code meja
- config/koneksi.php → koneksi database
- assets/ → file CSS, JS, dan gambar menu

## Persiapan Lokal
1. Pastikan XAMPP / Apache dan MySQL aktif
2. Buat database MySQL dengan nama sesuai konfigurasi
3. Sesuaikan koneksi database di config/koneksi.php
4. Akses aplikasi melalui browser:
   - http://localhost/seafood-amin/input_pesanan.php?meja=1
   - http://localhost/seafood-amin/monitor_dapur.php

## Catatan
Aplikasi ini masih dikembangkan secara native tanpa framework, dengan fokus pada proses bisnis restoran yang cepat dan sederhana.
