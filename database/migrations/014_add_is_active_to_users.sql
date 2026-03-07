-- =========================================
-- Add is_active column to users table
-- Migration: 014
-- =========================================

ALTER TABLE users 
ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER role;
