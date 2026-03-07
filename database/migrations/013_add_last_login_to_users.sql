-- =========================================
-- Add last_login column to users table
-- Migration: 013
-- =========================================

ALTER TABLE users 
ADD COLUMN last_login TIMESTAMP NULL;
