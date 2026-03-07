<?php

require_once __DIR__ . '/../Migration.php';

class CreatePasswordResetsTable extends Migration
{

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(100) NOT NULL,
            token VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_token (token),
            INDEX idx_email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS password_resets");
    }
}
