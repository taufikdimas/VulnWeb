<?php

require_once __DIR__ . '/../Migration.php';

class CreateSessionsTable extends Migration
{

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS sessions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            session_token VARCHAR(255) NOT NULL UNIQUE,
            ip_address VARCHAR(45) NOT NULL,
            user_agent TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            expires_at TIMESTAMP NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS sessions");
    }
}
