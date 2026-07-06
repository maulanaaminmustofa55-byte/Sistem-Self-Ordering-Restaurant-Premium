-- Migration: Add index on status column for better query performance
-- Date: 2026-06-29
-- Description: Menambahkan INDEX pada kolom status tabel pesanan untuk optimasi query KDS

USE restoran_amin;

-- Cek apakah index sudah ada (MySQL tidak support IF NOT EXISTS untuk INDEX)
-- Jalankan manual: SHOW INDEX FROM pesanan WHERE Key_name = 'idx_status';
-- Jika belum ada, jalankan:

ALTER TABLE pesanan ADD INDEX idx_status (status);

-- Verifikasi:
-- SHOW INDEX FROM pesanan WHERE Key_name = 'idx_status';