<?php

class AddIsActiveToUsers
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        echo "  → Adding is_active column to users table...\n";

        // Check if column already exists
        $checkSql = "SHOW COLUMNS FROM users LIKE 'is_active'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "ALTER TABLE users ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER role";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ is_active column added successfully\n";
            } else {
                echo "  ✗ Error adding is_active column: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ is_active column already exists\n";
        }

        return true;
    }

    public function down()
    {
        $sql = "ALTER TABLE users DROP COLUMN is_active";
        mysqli_query($this->db, $sql);
        return true;
    }
}
