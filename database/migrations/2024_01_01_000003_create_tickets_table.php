<?php

require_once __DIR__ . '/../Migration.php';

class CreateTicketsTable extends Migration
{

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS tickets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            subject VARCHAR(200) NOT NULL,
            description TEXT NOT NULL,
            status ENUM('open', 'in_progress', 'closed') DEFAULT 'open',
            priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS tickets");
    }
}
