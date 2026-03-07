<?php

/**
 * Base Migration Class
 * Laravel-style migration untuk PHP Native
 */
class Migration
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Run the migrations
     */
    public function up()
    {
        // Override in child class
    }

    /**
     * Reverse the migrations
     */
    public function down()
    {
        // Override in child class
    }

    /**
     * Execute raw SQL
     */
    protected function execute($sql)
    {
        if (! $this->db->query($sql)) {
            throw new Exception("Migration failed: " . $this->db->error);
        }
    }
}
