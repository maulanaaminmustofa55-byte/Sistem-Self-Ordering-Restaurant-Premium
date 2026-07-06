# AGENT.md — Aturan Pengembangan & Pemeliharaan Aplikasi Seafood Amin

Dokumen ini WAJIB dibaca dan dipatuhi oleh **semua model AI** dalam proses
pengembangan, debugging, refactoring, dan pemeliharaan aplikasi.

---

## 1. ARSITEKTUR APLIKASI

### 1.1 Stack Teknologi

| Layer  | Teknologi                        |
| ------ | -------------------------------- |
| Backend | PHP 8+ (native, tanpa framework) |
| Frontend | HTML5, CSS3, JavaScript (vanilla), Bootstrap 5 |
| Database | MySQL via `mysqli` |
| Font | Playfair Display (headings), Poppins (body) |
| Icon | Font Awesome 6 |
| QR Code | API eksternal: `api.qrserver.com` |

### 1.2 Database — `restoran_amin`

**Tabel: `pesanan`**

| Kolom             | Tipe         | Keterangan                          |
| ----------------- | ------------ | ----------------------------------- |
| `id`              | INT (PK, AI) | ID unik pesanan                     |
| `nama_pelanggan`  | VARCHAR      | Nama customer                       |
| `nomor_meja`      | INT/VARCHAR  | Nomor meja (1,2,3)                  |
| `detail_pesanan`  | TEXT         | String daftar item + total harga    |
| `status`          | VARCHAR      | Default: `proses`, selesai: `selesai` |
| `waktu_pesan`     | DATETIME     | Auto-set via `CURRENT_TIMESTAMP`    |

> **Catatan:** Belum ada file `.sql` skema database — harus dibuat jika setup dari awal.

### 1.3 Struktur File

```
seafood-amin/
├── AGENT.py              # Tool Python: validasi input, audit log (AI Ops)
├── AGENT.md              # <-- INI: Aturan untuk semua model AI
├── config/
│   └── koneksi.php       # Koneksi MySQL
├── assets/
│   ├── css/style.css     # CSS legacy (versi lama monitor)
│   ├── js/script.js      # JS legacy (versi lama monitor)
│   └── images/menu/      # 11 gambar menu
├── input_pesanan.php     # Halaman order customer (QR → menu → submit)
├── monitor_dapur.php     # Kitchen Display System (KDS) real-time
├── get_data.php          # API: ambil pesanan aktif (status != selesai)
├── update_status.php     # API: ubah status → selesai
├── generate_qr.php       # Generator QR code per meja
└── qr_codes/
    ├── meja_1.png
    ├── meja_2.png
    └── meja_3.png
```

---

## 2. ROLE USER & ALUR KERJA

### 2.1 Customer (Pelanggan)
1. Scan QR code di meja
2. Buka `input_pesanan.php?meja=X`
3. Lihat menu, pilih item (+ / -)
4. Isi nama, klik PLACE ORDER
5. Data masuk ke tabel `pesanan` dengan status default

### 2.2 Kitchen Staff (Dapur)
1. Buka `monitor_dapur.php` (auto-refresh 5 detik)
2. Lihat antrian pesanan
3. Klik "READY TO SERVE" → `update_status.php?id=X` → status jadi `selesai`
4. Order otomatis hilang dari layar

### 2.3 Admin (Restaurant Manager)
1. Buka `generate_qr.php`
2. Generate/download QR code untuk meja 1, 2, 3
3. Tempel QR di meja

---

## 3. ANALISIS KESELARASAN (ALIGNMENT CHECK)

### 3.1 ✅ Backend ↔ Database

| Backend              | Tabel/Kolom yang Dipakai             | Status |
| -------------------- | ------------------------------------ | ------ |
| `input_pesanan.php`  | INSERT ke `pesanan`                  | ✅     |
| `get_data.php`       | SELECT * WHERE status != 'selesai'   | ✅     |
| `update_status.php`  | UPDATE status='selesai' WHERE id=X   | ✅     |
| `koneksi.php`        | `restoran_amin` via `mysqli`         | ✅     |

### 3.2 ⚠️ Frontend ↔ Backend (Duplikasi UI)

**Masalah:** Ada **dua sistem UI** yang tidak konsisten:

| Sistem | File | Ciri |
| ------ | ---- | ---- |
| **Premium (baru)** | `monitor_dapur.php` (inline CSS/JS), `input_pesanan.php` (inline CSS/JS) | Dark theme + gold `#d4af37`, Playfair Display, Poppins |
| **Legacy (lama)** | `assets/css/style.css`, `assets/js/script.js` | Rustic theme + gold `#c9a03d`, bahasa informal "nungguin pesanan..." |

**Kesimpulan:** File `style.css` dan `script.js` kemungkinan dari versi lama
yang sudah tidak dipakai. **AI harus membersihkan** jika diminta refactor.
Semua UI baru pakai inline style di masing-masing file utama.

### 3.3 ⚠️ Sistem Logic Issues

| Issue | Detail | Severity |
| ----- | ------ | -------- |
| **SQL Injection** | `update_status.php` pakai `intval()` (OK), tapi `input_pesanan.php` pakai `mysqli_real_escape_string` untuk nama dan query INSERT langsung | ⚠️ Medium |
| **Hardcoded Domain** | `generate_qr.php` baris 38: `seapoodshrupp.great-site.net` — typo domain | ❌ High |
| **Auth None** | `monitor_dapur.php` dan `update_status.php` tanpa autentikasi — siapapun bisa akses | ⚠️ Medium |
| **Duplikasi QR Code logic** | `generateQR()` function + inline code di POST handler — kode duplikat | ⚠️ Low |
| **curl_close commented** | Baris 27 & 270: `// curl_close($ch); // TIDAK PERLU` — best practice: tetap close | ⚠️ Low |
| **Tidak ada validasi meja** | `input_pesanan.php` terima `meja` dari GET tanpa validasi | ⚠️ Low |

### 3.4 ✅ UI/UX Alignment Check

| Role | Halaman | Tema | Konsisten? |
| ---- | ------- | ---- | ---------- |
| Customer | `input_pesanan.php` | Premium dark + gold | ✅ Konsisten dg KDS |
| Kitchen | `monitor_dapur.php` | Premium dark + gold | ✅ Konsisten dg Order |
| Admin | `generate_qr.php` | Premium dark + gold | ✅ Konsisten |

Ketiga halaman utama menggunakan tema yang sama: dark background,
gold accent `#d4af37`, font Playfair Display + Poppins.

### 3.5 ✅ Menu Data Integrity

Menu didefinisikan di `input_pesanan.php` sebagai PHP array.
11 item menu + 11 gambar di `assets/images/menu/` — **1:1 match**.

| Gambar | Menu |
| ------ | ---- |
| `foto1.png` | Kakap Bakar Janur Kuning |
| `foto2.png` | Lobster Panggang Keju Mumbul |
| `foto3.png` | Udang Galah Bakar Mentega |
| `foto4.png` | Kepiting Soka Lada Hitam |
| `foto5.png` | Kepiting Soka Telur Asin |
| `foto6.png` | Nasi Rempah Segoro |
| `teh.png` | Es Teh Solo |
| `jeruk.png` | Es Jeruk Purut |
| `kelapa.png` | Es Kelapa Muda Kopyor |
| `bakwan.png` | Tempe Goreng Lapis Tepung |
| `tempe.png` | Bakwan Sayur Udang Rebon Garing |

> **⚠️ Catatan:** Nama file `bakwan.png` untuk menu "Tempe Goreng" dan
> `tempe.png` untuk menu "Bakwan Sayur" — **terbalik**. Perlu diperbaiki.

---

## 4. ATURAN WORKFLOW PENGEMBANGAN (WAJIB)

Semua model AI **WAJIB** mengikuti siklus ini dalam setiap perubahan kode:

```
┌─────────────────────────────────────────────────────────┐
│                    DEV CYCLE                            │
│                                                         │
│  1  Edit/Update code                                    │
│     ↓                                                   │
│  2  Test di LOCALHOST                                   │
│     ├─ ✅ Lolos → lanjut                                │
│     └─ ❌ Gagal → kembali ke step 1                     │
│     ↓                                                   │
│  3  git add + git commit + git push                     │
│     ↓                                                   │
│  4  Auto-test di GITHUB (CI/CD)                         │
│     ├─ ✅ Lolos → selesai                               │
│     └─ ❌ Gagal → analisis log error                    │
│         ↓                                               │
│      5  Analisis penyebab kegagalan                     │
│         ↓                                               │
│      6  Perbaiki kode                                   │
│         ↓                                               │
│      7  Test localhost → commit → push → auto-test lagi │
│         └─ (ulang sampai ✅)                            │
└─────────────────────────────────────────────────────────┘
```

### 4.1 Aturan Detail

#### Step 1: Edit/Update Code
- Pahami dulu konteks file sebelum edit
- JANGAN ubah struktur database tanpa dokumentasi
- JANGAN hapus fitur existing tanpa koordinasi
- Gunakan nama variabel yang konsisten dengan existing code

#### Step 2: Test di Localhost
- Jalankan XAMPP/Laragon
- Akses `http://localhost/seafood-amin/monitor_dapur.php`
- Test order: `http://localhost/seafood-amin/input_pesanan.php?meja=1`
- Test QR: `http://localhost/seafood-amin/generate_qr.php`
- Pastikan:
  - Orders masuk ke MySQL (`restoran_amin.pesanan`)
  - KDS menampilkan orders baru
  - Status bisa di-update
  - Tidak ada error PHP/Warning/Notice

#### Step 3: Push ke GitHub
```bash
git add .
git commit -m "deskripsi perubahan yang JELAS"
git push origin <branch>
```

#### Step 4: GitHub Auto-Test (CI/CD)
- Pipeline otomatis di GitHub Actions (jika ada)
- Cek syntax PHP (lint)
- Cek koneksi database (dummy)
- Cek HTML valid
- Jika tidak ada pipeline: **buat GitHub Actions workflow** untuk:
  - `php -l` semua file `.php`
  - Validasi HTML

#### Step 5-7: Analisis & Retest
- Baca log error dari GitHub Actions
- Identifikasi baris kode yang error
- Perbaiki → ulang dari Step 1
- JANGAN push ulang tanpa test localhost ulang

### 4.2 Aturan Tambahan

- **SETIAP** file `.php` yang diubah harus di-cek syntax: `php -l nama_file.php`
- **SETIAP** perubahan database harus ada migrasi SQL di folder `config/migrations/`
- **SETIAP** penambahan menu harus sinkron: array PHP + file gambar + path
- **DILARANG** push error/warning — cek error_reporting(E_ALL) dulu
- **WAJIB** backup database sebelum perubahan struktur

---

## 5. ATURAN KHUSUS UNTUK AI AGENTS

### 5.1 Saat Menambahkan Fitur Baru

1. Cek apakah fitur sudah ada (jangan duplikasi)
2. Pilih file yang tepat:
   - Order customer → `input_pesanan.php`
   - Tampilan dapur → `monitor_dapur.php` (+ `get_data.php` jika perlu data baru)
   - Admin/QR → `generate_qr.php`
3. Jika perlu API baru, buat file `.php` terpisah
4. Pastikan inline style konsisten (variabel CSS `#d4af37`, font Playfair/Poppins)

### 5.2 Saat Refactoring

1. **JANGAN** mengubah inline CSS/JS ke file eksternal (`style.css`/`script.js`) tanpa konfirmasi — arsitektur saat ini menggunakan inline
2. **JANGAN** mengubah struktur database tanpa file migrasi
3. **JANGAN** mengubah cara penyimpanan menu (array PHP di `input_pesanan.php`)
4. Jika membersihkan `style.css` / `script.js` — pastikan sudah tidak dipakai

### 5.3 Saat Debugging

1. Cek `error_log` PHP atau aktifkan `display_errors`
2. Cek log MySQL
3. Test manual di browser — jangan hanya lihat kode
4. Debug secara berurutan: Database → Backend → Frontend

### 5.4 Keamanan (Security Checklist)

- [ ] Input dari GET/POST disanitasi (`mysqli_real_escape_string` / `intval`)
- [ ] Tidak ada hardcoded credential di kode (sudah di `koneksi.php`)
- [ ] Tidak ada SQL injection
- [ ] Tidak ada XSS (gunakan `htmlspecialchars` untuk output)
- [ ] Jika perlu autentikasi, jangan bypass

---

## 6. LINTING & VALIDASI

### 6.1 PHP Lint
```bash
# Sebelum commit, jalankan:
php -l config/koneksi.php
php -l input_pesanan.php
php -l monitor_dapur.php
php -l get_data.php
php -l update_status.php
php -l generate_qr.php
```

### 6.2 HTML Validation (via CLI atau tool)
```bash
# Contoh dengan tidy:
tidy -e input_pesanan.php
```

### 6.3 Database Check
```sql
DESCRIBE pesanan;
SELECT COUNT(*) FROM pesanan WHERE status != 'selesai';
```

### 6.4 Image Check
```bash
# Pastikan semua gambar menu ada
dir assets\images\menu\
```
Harus ada 11 file, namanya harus 1:1 dengan array menu.

---

## 7. TROUBLESHOOTING

| Masalah | Penyebab | Solusi |
| ------- | -------- | ------ |
| KDS tidak muncul | DB connection error | Cek `koneksi.php` |
| Menu tidak tampil | Gambar hilang | Cek `assets/images/menu/` |
| QR tidak muncul | API qrserver.com down | Coba generate ulang |
| Orders tidak masuk | SQL error | Cek INSERT query, cek DB |
| Status tidak update | ID tidak valid | Cek `update_status.php?id=` |

---

## 8. VERSI & CHANGELOG

| Tanggal | Versi | Perubahan |
| ------- | ----- | --------- |
| 2026-06-23 | 1.0 | Initial AGENT.md — aturan dev, alignment analysis, workflow |

---

*Dokumen ini WAJIB dibaca oleh semua AI agent sebelum melakukan perubahan kode.
Jika ada yang tidak jelas, tanya user terlebih dahulu — JANGAN berasumsi.*
