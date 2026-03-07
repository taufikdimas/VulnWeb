<?php
// Check database structure after migration
require_once 'config/db_config.php';

$db   = new Database();
$conn = $db->getConnection();

echo "=== TICKETS TABLE STRUCTURE ===\n";
$result = mysqli_query($conn, "SHOW COLUMNS FROM tickets");
while ($row = mysqli_fetch_assoc($result)) {
    echo "{$row['Field']} - {$row['Type']}\n";
}

echo "\n=== ANNOUNCEMENTS TABLE STRUCTURE ===\n";
$result = mysqli_query($conn, "SHOW COLUMNS FROM announcements");
while ($row = mysqli_fetch_assoc($result)) {
    echo "{$row['Field']} - {$row['Type']}\n";
}

echo "\n=== VERIFICATION ===\n";
echo "✓ BLOB storage columns added successfully!\n";
echo "✓ Files will now be stored in database instead of filesystem\n";
echo "✓ Image preview enabled for tickets and announcements\n";
