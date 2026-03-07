<?php
// =========================================
// Database Migration Runner (Laravel-style)
// IntraCorp Portal
// =========================================

echo "===========================================\n";
echo "IntraCorp Portal - Database Migration\n";
echo "===========================================\n\n";

// Load database config
require_once __DIR__ . '/Config/db_config.php';

// Ensure database exists
echo "Checking database...\n";
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, null, DB_PORT);
if (! $conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$dbName = DB_NAME;
$result = mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
if ($result) {
    echo "✓ Database '$dbName' ready\n\n";
} else {
    echo "✗ Failed to create database: " . mysqli_error($conn) . "\n";
    exit(1);
}
mysqli_close($conn);

class Migrator
{
    private $db;
    private $migrationsPath;
    private $seedersPath;

    public function __construct()
    {
        $this->db             = new Database();
        $this->migrationsPath = __DIR__ . '/database/migrations/';
        $this->seedersPath    = __DIR__ . '/database/seeders/';
        $this->ensureMigrationsTable();
    }

    // Create migrations tracking table
    private function ensureMigrationsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            batch INT NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        try {
            $this->db->query($sql);
        } catch (Exception $e) {
            // Table might not exist yet, that's OK
        }
    }

    // Get executed migrations
    private function getExecutedMigrations()
    {
        try {
            $result = $this->db->query("SELECT migration FROM migrations");
            return array_column($this->db->fetchAll($result), 'migration');
        } catch (Exception $e) {
            return [];
        }
    }

    // Get current batch number
    private function getCurrentBatch()
    {
        try {
            $result = $this->db->query("SELECT MAX(batch) as max_batch FROM migrations");
            $row    = $this->db->fetch($result);
            return $row ? (int) $row['max_batch'] : 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    // Run pending migrations
    public function migrate()
    {
        $executed = $this->getExecutedMigrations();
        $batch    = $this->getCurrentBatch() + 1;

        // Get migration files (PHP files)
        $files = glob($this->migrationsPath . '*.php');
        sort($files);

        $pending = [];
        foreach ($files as $file) {
            $filename = basename($file);
            if (! in_array($filename, $executed)) {
                $pending[] = $file;
            }
        }

        if (empty($pending)) {
            echo "✓ No pending migrations.\n";
            return;
        }

        echo "Running " . count($pending) . " migration(s)...\n\n";

        foreach ($pending as $file) {
            $filename = basename($file);
            echo "Migrating: {$filename}... ";

            try {
                // Load migration file
                require_once $file;

                // Get class name from filename (e.g., 2024_01_01_000001_create_users_table.php -> CreateUsersTable)
                $className = $this->getClassNameFromFile($filename);

                // Instantiate and run migration
                $migration = new $className($this->db->getConnection());
                $migration->up();

                // Record migration
                $this->db->query(
                    "INSERT INTO migrations (migration, batch) VALUES ('$filename', $batch)"
                );

                echo "✓ DONE\n";
            } catch (Exception $e) {
                echo "✗ FAILED\n";
                echo "Error: " . $e->getMessage() . "\n";
                exit(1);
            }
        }

        echo "\n✓ Migration completed successfully!\n";
    }

    // Get class name from migration filename
    private function getClassNameFromFile($filename)
    {
        // Remove .php extension
        $name = str_replace('.php', '', $filename);

        // Remove timestamp prefix (2024_01_01_000001_)
        $parts          = explode('_', $name);
        $classNameParts = array_slice($parts, 4); // Skip date and number parts

        // Convert to PascalCase
        $className = implode('', array_map('ucfirst', $classNameParts));

        return $className;
    }

    // Run seeders
    public function seed()
    {
        echo "\nRunning seeders...\n\n";

        // Get seeder files
        $seeders = [
            'UserSeeder.php',
            'AnnouncementSeeder.php',
            'TicketSeeder.php',
        ];

        foreach ($seeders as $seederFile) {
            $file = $this->seedersPath . $seederFile;

            if (! file_exists($file)) {
                echo "  ⚠ Skipping {$seederFile} (not found)\n";
                continue;
            }

            try {
                require_once $file;
                $className = str_replace('.php', '', $seederFile);
                $seeder    = new $className($this->db->getConnection());
                $seeder->run();
            } catch (Exception $e) {
                echo "  ✗ Failed to run {$seederFile}: " . $e->getMessage() . "\n";
            }
        }

        echo "\n✓ Seeding completed!\n";
    }

    // Rollback last batch
    public function rollback()
    {
        $batch = $this->getCurrentBatch();

        if ($batch === 0) {
            echo "✓ Nothing to rollback.\n";
            return;
        }

        echo "Rolling back batch {$batch}...\n\n";

        $result     = $this->db->query("SELECT migration FROM migrations WHERE batch = $batch ORDER BY id DESC");
        $migrations = $this->db->fetchAll($result);

        foreach ($migrations as $migration) {
            $filename = $migration['migration'];
            echo "Rolling back: {$filename}... ";

            try {
                $file = $this->migrationsPath . $filename;

                if (file_exists($file)) {
                    require_once $file;
                    $className    = $this->getClassNameFromFile($filename);
                    $migrationObj = new $className($this->db->getConnection());
                    $migrationObj->down();
                }

                // Delete migration record
                $this->db->query("DELETE FROM migrations WHERE migration = '{$filename}'");

                echo "✓ DONE\n";
            } catch (Exception $e) {
                echo "✗ FAILED\n";
                echo "Error: " . $e->getMessage() . "\n";
            }
        }

        echo "\n✓ Rollback completed!\n";
    }

    // Show migration status
    public function status()
    {
        $executed = $this->getExecutedMigrations();
        $files    = glob($this->migrationsPath . '*.php');
        sort($files);

        echo "Migration Status:\n";
        echo str_repeat('-', 70) . "\n";
        printf("%-50s %s\n", "Migration", "Status");
        echo str_repeat('-', 70) . "\n";

        foreach ($files as $file) {
            $filename = basename($file);
            $status   = in_array($filename, $executed) ? '✓ Migrated' : '✗ Pending';
            printf("%-50s %s\n", $filename, $status);
        }

        echo str_repeat('-', 70) . "\n";
        echo "Total: " . count($files) . " | ";
        echo "Executed: " . count($executed) . " | ";
        echo "Pending: " . (count($files) - count($executed)) . "\n";
    }

    // Fresh migration (drop all tables and re-migrate)
    public function fresh()
    {
        echo "⚠️  WARNING: This will drop ALL tables!\n";
        echo "Continue? (yes/no): ";

        $handle = fopen("php://stdin", "r");
        $line   = fgets($handle);
        fclose($handle);

        if (trim($line) !== 'yes') {
            echo "Aborted.\n";
            return;
        }

        echo "\nDropping all tables...\n";

        // Get all tables
        $result = $this->db->query("SHOW TABLES");
        $tables = $this->db->fetchAll($result);

        foreach ($tables as $table) {
            $tableName = array_values($table)[0];
            echo "Dropping: {$tableName}... ";
            $this->db->query("DROP TABLE IF EXISTS {$tableName}");
            echo "✓\n";
        }

        echo "\nRunning migrations...\n\n";

        // Re-create migrations table and run all migrations
        $this->ensureMigrationsTable();
        $this->migrate();

        // Run seeders
        $this->seed();
    }
}

// Parse command
$command = $argv[1] ?? 'migrate';

$migrator = new Migrator();

switch ($command) {
    case 'migrate':
    case 'up':
        $migrator->migrate();
        break;

    case 'rollback':
    case 'down':
        $migrator->rollback();
        break;

    case 'status':
        $migrator->status();
        break;

    case 'fresh':
        $migrator->fresh();
        break;

    case 'seed':
        $migrator->seed();
        break;

    case 'help':
    default:
        echo "Available commands:\n\n";
        echo "  php migrate.php migrate   - Run pending migrations\n";
        echo "  php migrate.php rollback  - Rollback last batch\n";
        echo "  php migrate.php status    - Show migration status\n";
        echo "  php migrate.php fresh     - Drop all tables and re-migrate\n";
        echo "  php migrate.php seed      - Run database seeders\n";
        echo "  php migrate.php help      - Show this help\n";
        echo "\n";
        break;
}

echo "\n";
