<?php
// =========================================
// Add BLOB storage for profile photos
// Migration: 2024_01_01_000018
// =========================================

class AddBlobStorageForProfilePhotos
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        echo "  → Adding BLOB storage columns for profile photos...\n";

        // Add BLOB storage for user profile photos
        $checkSql = "SHOW COLUMNS FROM users LIKE 'profile_picture_data'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "ALTER TABLE users
                    ADD COLUMN profile_picture_data LONGBLOB NULL AFTER profile_picture,
                    ADD COLUMN profile_picture_mime_type VARCHAR(100) NULL AFTER profile_picture_data";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ Added profile_picture_data and profile_picture_mime_type to users table\n";
            } else {
                echo "  ✗ Error: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ profile_picture_data already exists in users table\n";
        }
    }

    public function down()
    {
        $sql = "ALTER TABLE users
                DROP COLUMN IF EXISTS profile_picture_data,
                DROP COLUMN IF EXISTS profile_picture_mime_type";
        mysqli_query($this->db, $sql);
    }
}
