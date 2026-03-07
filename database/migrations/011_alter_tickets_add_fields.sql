-- =========================================
-- Alter tickets table - Add priority, category, attachment, etc
-- Migration: 011
-- =========================================

ALTER TABLE tickets 
ADD COLUMN priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium' AFTER message,
ADD COLUMN category ENUM('hardware', 'software', 'network', 'access', 'email', 'other') DEFAULT 'other' AFTER priority,
ADD COLUMN attachment VARCHAR(255) NULL AFTER category,
ADD COLUMN assigned_to INT NULL AFTER attachment,
ADD COLUMN closed_at TIMESTAMP NULL AFTER updated_at,
ADD COLUMN closed_by INT NULL AFTER closed_at,
ADD INDEX idx_priority (priority),
ADD INDEX idx_category (category),
ADD INDEX idx_status (status),
ADD FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
ADD FOREIGN KEY (closed_by) REFERENCES users(id) ON DELETE SET NULL;
