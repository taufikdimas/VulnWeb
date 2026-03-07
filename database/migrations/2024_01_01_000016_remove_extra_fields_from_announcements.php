<?php

class RemoveExtraFieldsFromAnnouncements
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        echo "  → Removing extra columns from announcements table...\n";

        // Check if category column exists
        $checkSql = "SHOW COLUMNS FROM announcements LIKE 'category'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) > 0) {
            $sql = "ALTER TABLE announcements DROP COLUMN category";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ category column removed successfully\n";
            } else {
                echo "  ✗ Error removing category column: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ category column does not exist\n";
        }

        // Check if priority column exists
        $checkSql = "SHOW COLUMNS FROM announcements LIKE 'priority'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) > 0) {
            $sql = "ALTER TABLE announcements DROP COLUMN priority";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ priority column removed successfully\n";
            } else {
                echo "  ✗ Error removing priority column: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ priority column does not exist\n";
        }

        // Check if status column exists
        $checkSql = "SHOW COLUMNS FROM announcements LIKE 'status'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) > 0) {
            $sql = "ALTER TABLE announcements DROP COLUMN status";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ status column removed successfully\n";
            } else {
                echo "  ✗ Error removing status column: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ status column does not exist\n";
        }

        return true;
    }

    public function down()
    {
        $sql = "ALTER TABLE announcements
                ADD COLUMN category ENUM('general', 'important', 'urgent', 'event') DEFAULT 'general' AFTER content,
                ADD COLUMN priority ENUM('low', 'medium', 'high') DEFAULT 'medium' AFTER category,
                ADD COLUMN status ENUM('draft', 'published') DEFAULT 'published' AFTER attachment";
        mysqli_query($this->db, $sql);
        return true;
    }
}
