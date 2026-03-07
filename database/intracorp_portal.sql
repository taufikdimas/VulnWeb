-- =========================================
-- IntraCorp Portal Database Schema
-- Vulnerable Edition for Pentest Learning
-- =========================================

DROP DATABASE IF EXISTS intracorp_portal;
CREATE DATABASE intracorp_portal;
USE intracorp_portal;

-- =========================================
-- Table: users
-- Menyimpan data user (Employee & Admin)
-- =========================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('employee', 'admin') DEFAULT 'employee',
    department VARCHAR(50),
    phone VARCHAR(20),
    photo VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================================
-- Table: announcements
-- Pengumuman dari admin ke semua employee
-- =========================================
CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================================
-- Table: tickets
-- Tiket IT support dari employee
-- =========================================
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('open', 'in_progress', 'closed') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================================
-- Table: sessions
-- Session tracking
-- =========================================
CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================================
-- SAMPLE DATA (untuk testing)
-- =========================================

-- Admin account (password: admin123)
INSERT INTO users (username, email, password, full_name, role, department, phone) VALUES
('admin', 'admin@intracorp.local', 'admin123', 'System Administrator', 'admin', 'IT', '081234567890');

-- Employee accounts (password: employee123)
INSERT INTO users (username, email, password, full_name, role, department, phone) VALUES
('john.doe', 'john.doe@intracorp.local', 'employee123', 'John Doe', 'employee', 'Finance', '081234567891'),
('jane.smith', 'jane.smith@intracorp.local', 'employee123', 'Jane Smith', 'employee', 'HR', '081234567892'),
('bob.wilson', 'bob.wilson@intracorp.local', 'employee123', 'Bob Wilson', 'employee', 'Marketing', '081234567893');

-- Sample announcements
INSERT INTO announcements (title, content, created_by) VALUES
('Selamat Datang di IntraCorp Portal', 'Portal internal perusahaan telah diluncurkan. Silakan gunakan untuk mengakses informasi perusahaan.', 1),
('Pemeliharaan Sistem', 'Sistem akan menjalani pemeliharaan pada hari Sabtu, 25 Februari 2026 pukul 02:00 - 06:00 WIB.', 1);

-- Sample tickets
INSERT INTO tickets (user_id, subject, message, status) VALUES
(2, 'Lupa Password Email', 'Halo IT Support, saya lupa password email kantor saya. Mohon bantuannya.', 'open'),
(3, 'Printer Tidak Berfungsi', 'Printer di ruang HR tidak bisa mencetak. Sudah dicoba restart tapi tetap error.', 'in_progress'),
(4, 'Request Akses Database', 'Mohon berikan akses ke database marketing untuk keperluan reporting.', 'open');

-- =========================================
-- NOTES VULNERABILITY:
-- =========================================
-- 1. Password disimpan plain text (tidak di-hash)
-- 2. Tidak ada prepared statement (SQL Injection)
-- 3. Tidak ada CSRF protection
-- 4. Session management lemah
-- 5. File upload tanpa validasi
-- =========================================
