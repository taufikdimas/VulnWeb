<?php

require_once __DIR__ . '/../Migration.php';

class CreateAnnouncementsTable extends Migration
{

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS announcements (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(200) NOT NULL,
            content TEXT NOT NULL,
            author_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS announcements");
    }
}
