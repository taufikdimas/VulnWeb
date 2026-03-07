<?php

class AlterTicketsAddFields
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Check and add each column individually
        $columnsToAdd = [
            'priority'    => "ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium'",
            'category'    => "ENUM('hardware', 'software', 'network', 'access', 'email', 'other') DEFAULT 'other'",
            'attachment'  => "VARCHAR(255) NULL",
            'assigned_to' => "INT NULL",
            'closed_at'   => "TIMESTAMP NULL",
            'closed_by'   => "INT NULL",
        ];

        // Determine which column to use as AFTER reference for priority/category
        $result         = mysqli_query($this->db, "SHOW COLUMNS FROM tickets LIKE 'message'");
        $hasMessage     = mysqli_num_rows($result) > 0;
        $result         = mysqli_query($this->db, "SHOW COLUMNS FROM tickets LIKE 'description'");
        $hasDescription = mysqli_num_rows($result) > 0;
        $afterColumn    = $hasMessage ? 'message' : ($hasDescription ? 'description' : 'subject');

        foreach ($columnsToAdd as $column => $definition) {
            $result = mysqli_query($this->db, "SHOW COLUMNS FROM tickets LIKE '$column'");
            if (mysqli_num_rows($result) == 0) {
                // Column doesn't exist, add it
                $afterPos = $column;
                if ($column == 'priority') {
                    $afterPos = $afterColumn;
                } elseif ($column == 'category') {
                    $afterPos = 'priority';
                } elseif ($column == 'attachment') {
                    $afterPos = 'category';
                } elseif ($column == 'assigned_to') {
                    $afterPos = 'attachment';
                } elseif ($column == 'closed_at') {
                    $afterPos = 'updated_at';
                } elseif ($column == 'closed_by') {
                    $afterPos = 'closed_at';
                }

                $sql = "ALTER TABLE tickets ADD COLUMN $column $definition AFTER $afterPos";
                mysqli_query($this->db, $sql);
                echo "($column added) ";
            }
        }

        // Add indexes if they don't exist
        $result = mysqli_query($this->db, "SHOW INDEX FROM tickets WHERE Key_name = 'idx_priority'");
        if (mysqli_num_rows($result) == 0) {
            mysqli_query($this->db, "ALTER TABLE tickets ADD INDEX idx_priority (priority)");
        }

        $result = mysqli_query($this->db, "SHOW INDEX FROM tickets WHERE Key_name = 'idx_category'");
        if (mysqli_num_rows($result) == 0) {
            mysqli_query($this->db, "ALTER TABLE tickets ADD INDEX idx_category (category)");
        }

        $result = mysqli_query($this->db, "SHOW INDEX FROM tickets WHERE Key_name = 'idx_status'");
        if (mysqli_num_rows($result) == 0) {
            mysqli_query($this->db, "ALTER TABLE tickets ADD INDEX idx_status (status)");
        }

        // Add foreign keys if they don't exist (using @ to suppress errors as FK constraints are tricky to check)
        @mysqli_query($this->db, "ALTER TABLE tickets ADD CONSTRAINT fk_tickets_assigned_to FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL");
        @mysqli_query($this->db, "ALTER TABLE tickets ADD CONSTRAINT fk_tickets_closed_by FOREIGN KEY (closed_by) REFERENCES users(id) ON DELETE SET NULL");
    }

    public function down()
    {
        $sql = "ALTER TABLE tickets
                DROP COLUMN priority,
                DROP COLUMN category,
                DROP COLUMN attachment,
                DROP COLUMN assigned_to,
                DROP COLUMN closed_at,
                DROP COLUMN closed_by";

        mysqli_query($this->db, $sql);
    }
}
