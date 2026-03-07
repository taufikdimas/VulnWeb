<?php

class AddLastLoginToUsers
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        echo "  → Adding last_login column to users table...\n";

        // Check if column already exists
        $checkSql = "SHOW COLUMNS FROM users LIKE 'last_login'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "ALTER TABLE users ADD COLUMN last_login TIMESTAMP NULL";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ last_login column added successfully\n";
            } else {
                echo "  ✗ Error adding last_login column: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ last_login column already exists\n";
        }

        return true;
    }

    public function down()
    {
        $sql = "ALTER TABLE users DROP COLUMN last_login";
        mysqli_query($this->db, $sql);
        return true;
    }
}
