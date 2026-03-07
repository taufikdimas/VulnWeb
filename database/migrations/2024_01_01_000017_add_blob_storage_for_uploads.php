<?php
// =========================================
// Add BLOB storage for file uploads
// Migration: 2024_01_01_000017
// =========================================

class AddBlobStorageForUploads
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        echo "  → Adding BLOB storage columns...\n";

        // Add BLOB storage for tickets attachments
        $checkSql = "SHOW COLUMNS FROM tickets LIKE 'attachment_data'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "ALTER TABLE tickets
                    ADD COLUMN attachment_data LONGBLOB NULL AFTER attachment,
                    ADD COLUMN attachment_mime_type VARCHAR(100) NULL AFTER attachment_data";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ Added attachment_data and attachment_mime_type to tickets table\n";
            } else {
                echo "  ✗ Error: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ attachment_data already exists in tickets table\n";
        }

        // Add BLOB storage for announcements attachments
        $checkSql = "SHOW COLUMNS FROM announcements LIKE 'attachment_data'";
        $result   = mysqli_query($this->db, $checkSql);

        if (mysqli_num_rows($result) == 0) {
            $sql = "ALTER TABLE announcements
                    ADD COLUMN attachment_data LONGBLOB NULL AFTER attachment,
                    ADD COLUMN attachment_mime_type VARCHAR(100) NULL AFTER attachment_data";
            if (mysqli_query($this->db, $sql)) {
                echo "  ✓ Added attachment_data and attachment_mime_type to announcements table\n";
            } else {
                echo "  ✗ Error: " . mysqli_error($this->db) . "\n";
            }
        } else {
            echo "  ℹ attachment_data already exists in announcements table\n";
        }
    }

    public function down()
    {
        $sql = "ALTER TABLE tickets
                DROP COLUMN IF EXISTS attachment_data,
                DROP COLUMN IF EXISTS attachment_mime_type";
        mysqli_query($this->db, $sql);

        $sql = "ALTER TABLE announcements
                DROP COLUMN IF EXISTS attachment_data,
                DROP COLUMN IF EXISTS attachment_mime_type";
        mysqli_query($this->db, $sql);
    }
}
