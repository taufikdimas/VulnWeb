<?php

class CreateTicketCommentsTable
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Check if table already exists
        $result = mysqli_query($this->db, "SHOW TABLES LIKE 'ticket_comments'");
        if (mysqli_num_rows($result) > 0) {
            echo "(table already exists, skipping) ";
            return;
        }

        $sql = "CREATE TABLE ticket_comments (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    ticket_id INT NOT NULL,
                    user_id INT NOT NULL,
                    comment TEXT NOT NULL,
                    is_internal TINYINT(1) DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                    INDEX idx_ticket_id (ticket_id)
                )";

        mysqli_query($this->db, $sql);
    }

    public function down()
    {
        mysqli_query($this->db, "DROP TABLE IF EXISTS ticket_comments");
    }
}
