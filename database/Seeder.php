<?php

/**
 * Base Seeder Class
 * Laravel-style seeder untuk PHP Native
 */
class Seeder
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Run the database seeds
     */
    public function run()
    {
        // Override in child class
    }

    /**
     * Execute raw SQL
     */
    protected function execute($sql)
    {
        if (! $this->db->query($sql)) {
            throw new Exception("Seeder failed: " . $this->db->error);
        }
    }

    /**
     * Insert data into table
     */
    protected function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));

        // Handle NULL values properly
        $values = array_map(function ($value) {
            if ($value === null || $value === null) {
                return 'NULL';
            }
            return "'" . $this->db->real_escape_string($value) . "'";
        }, array_values($data));

        $valuesStr = implode(', ', $values);
        $sql       = "INSERT INTO {$table} ({$columns}) VALUES ({$valuesStr})";
        $this->execute($sql);
    }
}
