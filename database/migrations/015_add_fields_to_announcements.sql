-- =========================================
-- Add fields to announcements table
-- Migration: 015
-- =========================================

-- Add category column
ALTER TABLE announcements 
ADD COLUMN category ENUM('general', 'important', 'urgent', 'event') DEFAULT 'general' AFTER content;

-- Add priority column
ALTER TABLE announcements 
ADD COLUMN priority ENUM('low', 'medium', 'high') DEFAULT 'medium' AFTER category;

-- Add attachment column
ALTER TABLE announcements 
ADD COLUMN attachment VARCHAR(255) NULL AFTER priority;

-- Add status column
ALTER TABLE announcements 
ADD COLUMN status ENUM('draft', 'published') DEFAULT 'published' AFTER attachment;
