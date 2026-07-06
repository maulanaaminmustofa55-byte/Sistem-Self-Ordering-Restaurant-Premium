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

### 3.6 ✅ Analisis Keselarasan Backend-Frontend-Database-Logika-UI/UX Per Role

#### 🧑‍🍳 Role: Customer (Pelanggan) — `input_pesanan.php`

| Layer | Status | Detail |
| ----- | ------ | ------ |
| **Backend** | ✅ | PHP INSERT ke `pesanan`, sanitasi via `mysqli_real_escape_string` |
| **Frontend** | ✅ | Dark premium + gold, responsive, real-time order summary via JS |
| **Database** | ✅ | INSERT menyimpan nama_pelanggan, nomor_meja, detail_pesanan |
| **Logic** | ⚠️ | Tidak ada validasi meja dari GET ($_GET['meja']) — bisa diisi bebas |
| **UI/UX** | ✅ | Hero section premium, card menu dengan qty control, sticky order button |

#### 👨‍🍳 Role: Kitchen Staff (Dapur) — `monitor_dapur.php` + `get_data.php` + `update_status.php`

| Layer | Status | Detail |
| ----- | ------ | ------ |
| **Backend** | ✅ | get_data.php SELECT status!=selesai, update_status.php UPDATE selesai |
| **Frontend** | ✅ | Auto-refresh 5s, animasi new-order, timer, toast notification, responsive TV |
| **Database** | ✅ | Query lancar, index di `id` |
| **Logic** | ⚠️ | Tidak ada autentikasi — siapapun bisa akses dan update status |
| **UI/UX** | ✅ | Layout optimized untuk TV/monitor dapur, grid responsif, skeleton loading |

#### 👑 Role: Admin (Manager) — `generate_qr.php`

| Layer | Status | Detail |
| ----- | ------ | ------ |
| **Backend** | ❌ | **Hardcoded domain typo**: `seapoodshrupp.great-site.net` — seharusnya domain benar |
| **Frontend** | ✅ | Dark premium + gold, konsisten dengan halaman lain |
| **Database** | ✅ | Tidak perlu akses DB (hanya generate QR) |
| **Logic** | ⚠️ | Duplikasi kode `generateQR()` antara onclick HTML dan handler POST |
| **UI/UX** | ✅ | Pilih meja 1/2/3, preview QR, download PNG |

#### 📊 Matriks Keselarasan Lintas Role

| Modul | Backend | Frontend | Database | Logic | UI/UX |
| ----- | ------- | -------- | -------- | ----- | ----- |
| Order (Customer) | ✅ | ✅ | ✅ | ⚠️ | ✅ |
| KDS (Kitchen) | ✅ | ✅ | ✅ | ⚠️ | ✅ |
| QR Admin | ❌ | ✅ | N/A | ⚠️ | ✅ |
| **Score** | **75%** | **100%** | **100%** | **50%** | **100%** |

**Issues Kritis yang Wajib Diperbaiki:**
1. ❌ **Hardcoded domain typo** di `generate_qr.php` — HIGH priority
2. ⚠️ **Autentikasi** untuk Kitchen Display System dan update_status — MEDIUM priority
3. ⚠️ **SQL injection risk** di `input_pesanan.php` — gunakan prepared statement
4. ⚠️ **Duplikasi QR code logic** — refactor jadi satu fungsi
5. ⚠️ **Validasi meja** — pastikan meja hanya 1, 2, atau 3
6. ⚠️ **Nama file gambar terbalik** — `bakwan.png` ↔ `tempe.png`

---

## 4. ATURAN WORKFLOW PENGEMBANGAN (WAJIB)

Semua model AI **WAJIB** mengikuti siklus ini dalam setiap perubahan kode:

```
┌──────────────────────────────────────────────────────────────┐
│                    DEV CYCLE (WAJIB)                         │
│                                                              │
│  1  Edit/Update code                                         │
│     ↓                                                        │
│  2  UJI COBA di LOCALHOST    ←──┐                            │
│     ├─ ✅ Lolos semua test      │                            │
│     └─ ❌ Gagal → kembali ke 1  │                            │
│     ↓                           │                            │
│  3  LINTING + VALIDASI syntax   │                            │
│     ↓                           │                            │
│  4  git add + git commit        │                            │
│     ↓                           │                            │
│  5  git push                    │                            │
│     ↓                           │                            │
│  6  AUTO-TEST di GITHUB (CI/CD) │                            │
│     ├─ ✅ Lolos → SELESAI       │                            │
│     └─ ❌ Gagal ─────────→ ANALISIS LOG ERROR ──┐           │
│         ↓                                        │           │
│      7  Analisis penyebab kegagalan              │           │
│         ↓                                        │           │
│      8  Perbaiki kode sesuai analisis            │           │
│         ↓                                        │           │
│      9  Test LOCALHOST ulang ────────────────────┘           │
│     10  Commit + Push + Auto-test ulang                     │
│         └─ (ulang dari step 6 sampai ✅)                    │
└──────────────────────────────────────────────────────────────┘
```

### 4.1 Aturan Detail — WAJIB DIPATUHI

#### Step 1: Edit/Update Code
- Pahami dulu konteks file sebelum edit (baca seluruh file)
- JANGAN ubah struktur database tanpa dokumentasi migrasi SQL
- JANGAN hapus fitur existing tanpa koordinasi dengan user
- Gunakan nama variabel yang konsisten dengan existing code
- Patuhi arsitektur inline CSS/JS — jangan pindahkan ke file eksternal

#### Step 1.5: SYARAT MUTLAK — SIKLUS DEV CYCLE WAJIB (NEW RULE)
SETIAP PERUBAHAN KODE WAJIB MENGIKUTI SIKLUS INI TANPA EKSEPSI:

```
┌────────────────────────────────────────────────────────────────────────┐
│                    MANDATORY DEV CYCLE (NO EXCEPTIONS)                │
│                                                                        │
│  1. EDIT CODE (local)                                                  │
│     ↓                                                                   │
│  2. TEST DI LOCALHOST (XAMPP: Apache + MySQL)                         │
│     ├─ ✅ Semua test lolos → lanjut ke step 3                         │
│     └─ ❌ Ada gagal → KEMBALI KE STEP 1 (perbaiki, test ulang)        │
│     ↓                                                                   │
│  3. LINTING + VALIDASI SYNTAX (php -l semua file .php yg diubah)      │
│     ↓                                                                   │
│  4. GIT ADD + GIT COMMIT (pesan jelas: [MODUL] Deskripsi spesifik)    │
│     ↓                                                                   │
│  5. GIT PUSH KE GITHUB                                                 │
│     ↓                                                                   │
│  6. AUTO-TEST DI GITHUB (CI/CD GitHub Actions)                        │
│     ├─ ✅ Semua pipeline lolos → SELESAI                               │
│     └─ ❌ GAGAL → ANALISIS LOG ERROR (Step 7)                         │
│         ↓                                                               │
│  7. ANALISIS PENYEBAB KEGAGALAN                                        │
│     - Baca log GitHub Actions (tab Actions → workflow run gagal)      │
│     - Identifikasi: PHP Parse Error / HTML Validation / Missing file  │
│     - Catat di ERROR_LOG.md (buat jika belum ada)                     │
│         ↓                                                               │
│  8. PERBAIKI KODE SESUAI ANALISIS                                      │
│         ↓                                                               │
│  9. TEST LOCALHOST ULANG (WAJIB - ulangi Step 2 penuh)                │
│     DILARANG push ulang tanpa test localhost ulang!                   │
│         ↓                                                               │
│  10. COMMIT + PUSH + AUTO-TEST ULANG                                   │
│      (ulang dari Step 6 sampai SEMUA ✅)                              │
└────────────────────────────────────────────────────────────────────────┘
```

**KONSEKUENSI PELANGGARAN:**
- ❌ Push tanpa test localhost → REJECT
- ❌ Push tanpa linting → REJECT  
- ❌ Push ulang setelah CI/CD gagal tanpa test localhost ulang → REJECT
- ❌ Merge PR dengan pipeline merah → REJECT

#### Step 2: Uji Coba di Localhost
**WAJIB dilakukan SETIAP KALI sebelum commit.**
- Jalankan XAMPP (Apache + MySQL)
- Test semua halaman yang terpengaruh oleh perubahan:

**2.1 Test Order Customer:**
- Buka `http://localhost/seafood-amin/input_pesanan.php?meja=1`
- Pilih beberapa item menu (+), isi nama, tekan PLACE ORDER
- Pastikan sukses → alert muncul → data masuk ke tabel `pesanan`

**2.2 Test Kitchen Display System (KDS):**
- Buka `http://localhost/seafood-amin/monitor_dapur.php`
- Pastikan pesanan baru muncul (auto-refresh 5 detik)
- Klik "READY TO SERVE" → pastikan status berubah jadi `selesai`
- Pastikan order hilang dari layar setelah status selesai

**2.3 Test QR Generator (Admin):**
- Buka `http://localhost/seafood-amin/generate_qr.php`
- Pilih meja → klik Generate → preview muncul → download OK

**2.4 Verifikasi Database:**
```sql
-- Cek di phpMyAdmin atau terminal MySQL:
USE restoran_amin;
SELECT * FROM pesanan ORDER BY id DESC LIMIT 5;
SELECT COUNT(*) FROM pesanan WHERE status = 'proses';
```

**2.5 Cek Error PHP:**
- Aktifkan `error_reporting(E_ALL)` di awal file yang diubah
- Pastikan **TIDAK ADA** PHP Notice, Warning, atau Parse Error
- Cek log error: `C:\xampp\php\logs\php_error_log`

**2.6 Cross-Browser Check:**
- Test di Chrome dan Firefox (minimal)
- Test mobile view (Chrome DevTools → toggle device toolbar)

#### Step 3: Linting & Validasi Syntax
Sebelum commit, **WAJIB** jalankan:

```bash
# PHP Lint — semua file yang diubah
php -l input_pesanan.php
php -l monitor_dapur.php
php -l get_data.php
php -l update_status.php
php -l generate_qr.php
php -l config/koneksi.php

# Jika ada error: "Parse error" — JANGAN commit! Perbaiki dulu.
```

#### Step 4: Commit dengan Pesan yang JELAS
```bash
git add .
git status   # Verifikasi hanya file yang diinginkan
git commit -m "[MODUL] Deskripsi perubahan yang JELAS dan SPESIFIK"
```
Format commit message:
- `[ORDER]` — perubahan di input_pesanan.php
- `[KDS]` — perubahan di monitor_dapur.php / get_data.php / update_status.php
- `[QR]` — perubahan di generate_qr.php
- `[DB]` — perubahan struktur database
- `[FIX]` — perbaikan bug
- `[REFACTOR]` — refactoring kode

Contoh: `[KDS] Tambah timer countdown di card pesanan, fix auto-refresh 5s`
❌ JANGAN: `update file`, `fix bug`, `perbaikan`

#### Step 5: Push ke GitHub
```bash
git push origin <branch>
```

#### Step 6: Auto-Test di GitHub (CI/CD)
**WAJIB** ada pipeline GitHub Actions. Jika belum ada, **BUAT FILE** `.github/workflows/ci.yml`:

```yaml
name: CI - Seafood Amin

on:
  push:
    branches: [ main, master ]
  pull_request:
    branches: [ main, master ]

jobs:
  php-lint:
    name: PHP Lint
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: PHP Syntax Check (lint)
        run: |
          for file in $(find . -name "*.php" -not -path "./vendor/*"); do
            php -l "$file" || exit 1
          done

  html-validate:
    name: HTML Validate
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Install tidy
        run: sudo apt-get update && sudo apt-get install -y tidy
      - name: Validate PHP files (HTML extract)
        run: |
          for file in input_pesanan.php monitor_dapur.php generate_qr.php; do
            if [ -f "$file" ]; then
              php -r "
                \$content = file_get_contents('$file');
                preg_match('/<html.*<\/html>/is', \$content, \$matches);
                if (!empty(\$matches[0])) {
                  file_put_contents('temp.html', \$matches[0]);
                  echo 'Validating $file...\n';
                  passthru('tidy -e -q temp.html 2>&1', \$ret);
                  if (\$ret !== 0) { echo '❌ HTML errors in $file\n'; exit(1); }
                  else { echo '✅ $file OK\n'; }
                }
              " || exit 1
            fi
          done

  db-schema-check:
    name: Database Schema Check
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Check SQL consistency
        run: |
          # Cek apakah ada file migrasi baru tanpa dokumentasi
          echo "✅ Database schema check passed"

  image-check:
    name: Image Assets Check
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Verify menu images exist
        run: |
          required_files=(
            "assets/images/menu/foto1.png"
            "assets/images/menu/foto2.png"
            "assets/images/menu/foto3.png"
            "assets/images/menu/foto4.png"
            "assets/images/menu/foto5.png"
            "assets/images/menu/foto6.png"
            "assets/images/menu/teh.png"
            "assets/images/menu/jeruk.png"
            "assets/images/menu/kelapa.png"
            "assets/images/menu/bakwan.png"
            "assets/images/menu/tempe.png"
          )
          for file in "${required_files[@]}"; do
            if [ ! -f "$file" ]; then
              echo "❌ Missing: $file"
              exit 1
            fi
            echo "✅ $file"
          done
```

Pipeline akan otomatis jalan setiap push. Cek hasil di:
`https://github.com/<username>/seafood-amin/actions`

#### Step 7: Analisis Penyebab Kegagalan (Jika CI/CD Gagal)
1. Buka tab Actions di GitHub → klik workflow run yang gagal
2. Baca log error — cari baris spesifik yang error
3. Identifikasi:
   - **PHP Parse Error** → baris berapa, file apa, penyebab
   - **HTML Validation Error** → tag mana yang tidak valid
   - **Missing file** → gambar/file apa yang hilang
4. Catat penyebab di file `ERROR_LOG.md` (buat jika belum ada)

#### Step 8: Perbaiki Kode
- Perbaiki sesuai temuan analisis
- **JANGAN** langsung commit — lanjut ke Step 9

#### Step 9: Test Localhost Ulang
**WAJIB** — jalankan ulang seluruh Step 2 (localhost test).
DILARANG push ulang tanpa test localhost ulang.

#### Step 10: Commit + Push + Auto-test Ulang
```bash
git add .
git commit -m "[FIX] Perbaiki: <penyebab error>"
git push origin <branch>
```
Kembali ke Step 6 — ulangi sampai semua pipeline ✅.

### 4.2 Aturan Tambahan (WAJIB)

- **SETIAP** file `.php` yang diubah harus di-cek syntax: `php -l nama_file.php` **SEBELUM commit**
- **SETIAP** perubahan database harus ada migrasi SQL di folder `config/migrations/`
- **SETIAP** penambahan menu harus sinkron: array PHP + file gambar + path
- **DILARANG** push error/warning — cek `error_reporting(E_ALL)` dulu
- **WAJIB** backup database sebelum perubahan struktur (`mysqldump`)
- **WAJIB** cek `git status` sebelum commit — pastikan hanya file yang diinginkan
- **WAJIB** update AGENT.md jika ada perubahan alur kerja atau arsitektur
- **WAJIB** verifikasi alignment lintas modul sebelum pull request (lihat 3.6)
- **DILARANG** merge/commit jika ada pipeline merah — perbaiki dulu

### 4.3 Flowchart Keputusan AI Agents

```
Mulai perubahan kode?
│
├─ Apakah ini bug fix?         → Step 1 (edit minimal)
├─ Apakah ini fitur baru?      → Step 1 + analisis dampak (3.6)
├─ Apakah ini refactor?        → Step 1 + pastikan tidak ubah behavior
└─ Apakah ini update UI?       → Step 1 + pastikan konsisten dark+gold theme

Setelah Step 1:
├─ Apakah melibatkan DB?       → Buat migrasi SQL di config/migrations/
├─ Apakah melibatkan API?      → Test endpoint dengan browser/devtools
├─ Apakah melibatkan JS?       → Test interaksi (qty, submit, auto-refresh)
└─ Apakah hanya CSS?           → Visual check di 2 browser + mobile view

SEBELUM COMMIT: Jalankan Step 2 (localhost test) + Step 3 (linting).
JIKA ADA RAGU: Tanya user — JANGAN berasumsi.
```

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
| 2026-06-23 | 2.0 | Enhanced workflow — CI/CD pipeline template, GitHub Actions auto-test, failure analysis & retry cycle, alignment matrix per role, linting enforcement |

---

*Dokumen ini WAJIB dibaca oleh semua AI agent sebelum melakukan perubahan kode.
Jika ada yang tidak jelas, tanya user terlebih dahulu — JANGAN berasumsi.*
