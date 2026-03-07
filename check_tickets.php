<?php
require_once 'config/db_config.php';
$db = new Database();
$result = $db->query('DESCRIBE tickets');
echo "Tickets table columns:\n";
while($row = mysqli_fetch_assoc($result)) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
?>
