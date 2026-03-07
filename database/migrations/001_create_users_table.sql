-- =========================================
-- Create users table
-- Migration: 001
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
