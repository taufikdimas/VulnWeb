<?php

class AddFieldsToAnnouncements
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        echo "  → Adding new columns to announcements table...\n";

        // Check if category column exists
        $checkSql = "SHOW COLUMNS FROM announcements LIKE 'category'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "ALTER TABLE announcements ADD COLUMN category ENUM('general', 'important', 'urgent', 'event') DEFAULT 'general' AFTER content";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ category column added successfully\n";
            } else {
                echo "  ✗ Error adding category column: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ category column already exists\n";
        }

        // Check if priority column exists
        $checkSql = "SHOW COLUMNS FROM announcements LIKE 'priority'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "ALTER TABLE announcements ADD COLUMN priority ENUM('low', 'medium', 'high') DEFAULT 'medium' AFTER category";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ priority column added successfully\n";
            } else {
                echo "  ✗ Error adding priority column: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ priority column already exists\n";
        }

        // Check if attachment column exists
        $checkSql = "SHOW COLUMNS FROM announcements LIKE 'attachment'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "ALTER TABLE announcements ADD COLUMN attachment VARCHAR(255) NULL AFTER priority";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ attachment column added successfully\n";
            } else {
                echo "  ✗ Error adding attachment column: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ attachment column already exists\n";
        }

        // Check if status column exists
        $checkSql = "SHOW COLUMNS FROM announcements LIKE 'status'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "ALTER TABLE announcements ADD COLUMN status ENUM('draft', 'published') DEFAULT 'published' AFTER attachment";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ status column added successfully\n";
            } else {
                echo "  ✗ Error adding status column: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ status column already exists\n";
        }

        return true;
    }

    public function down()
    {
        $sql = "ALTER TABLE announcements
                DROP COLUMN IF EXISTS category,
                DROP COLUMN IF EXISTS priority,
                DROP COLUMN IF EXISTS attachment,
                DROP COLUMN IF EXISTS status";
        mysqli_query($this->db, $sql);
        return true;
    }
}
