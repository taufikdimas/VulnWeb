<?php

require_once __DIR__ . '/../Migration.php';

class CreateUsersTable extends Migration
{

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL,
            full_name VARCHAR(100) NOT NULL,
            role ENUM('admin', 'employee') NOT NULL DEFAULT 'employee',
            department VARCHAR(100) DEFAULT NULL,
            phone VARCHAR(20) DEFAULT NULL,
            profile_picture VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS users");
    }
}
