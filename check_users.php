<?php
require_once 'config/db_config.php';

$db   = new Database();
$conn = $db->getConnection();

echo "=== USERS TABLE STRUCTURE ===\n";
$result = mysqli_query($conn, "SHOW COLUMNS FROM users");
while ($row = mysqli_fetch_assoc($result)) {
    echo "{$row['Field']} - {$row['Type']}\n";
}
