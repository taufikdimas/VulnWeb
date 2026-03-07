-- =========================================
-- Seed tickets
-- Migration: 008
-- =========================================

INSERT INTO tickets (user_id, subject, message, status) VALUES
(2, 'Lupa Password Email', 'Halo IT Support, saya lupa password email kantor saya. Mohon bantuannya.', 'open'),
(3, 'Printer Tidak Berfungsi', 'Printer di ruang HR tidak bisa mencetak. Sudah dicoba restart tapi tetap error.', 'in_progress'),
(4, 'Request Akses Database', 'Mohon berikan akses ke database marketing untuk keperluan reporting.', 'open');
