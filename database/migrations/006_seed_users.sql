-- =========================================
-- Seed users (Admin + Employees)
-- Migration: 006
-- =========================================

-- Admin account (password: admin123)
INSERT INTO users (username, email, password, full_name, role, department, phone) VALUES
('admin', 'admin@intracorp.local', 'admin123', 'System Administrator', 'admin', 'IT', '081234567890');

-- Employee accounts (password: employee123)
INSERT INTO users (username, email, password, full_name, role, department, phone) VALUES
('john.doe', 'john.doe@intracorp.local', 'employee123', 'John Doe', 'employee', 'Finance', '081234567891'),
('jane.smith', 'jane.smith@intracorp.local', 'employee123', 'Jane Smith', 'employee', 'HR', '081234567892'),
('bob.wilson', 'bob.wilson@intracorp.local', 'employee123', 'Bob Wilson', 'employee', 'Marketing', '081234567893');
