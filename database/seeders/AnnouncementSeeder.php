<?php

require_once __DIR__ . '/../Seeder.php';

class AnnouncementSeeder extends Seeder
{

    public function run()
    {
        echo "  → Seeding announcements...\n";

        $this->insert('announcements', [
            'title'     => 'Welcome to IntraCorp IT Helpdesk',
            'content'   => '<p>Welcome to our IT Helpdesk portal! You can now submit IT tickets, track their status, and stay updated with IT announcements.</p><p><strong>Note:</strong> This is a vulnerable application for educational purposes only!</p>',
            'author_id' => 1,
        ]);

        $this->insert('announcements', [
            'title'     => 'Office Holiday Schedule',
            'content'   => '<p>Please note the following holidays:</p><ul><li>New Year: January 1st</li><li>Independence Day: August 17th</li></ul><script>console.log("XSS Vulnerability Demo")</script>',
            'author_id' => 1,
        ]);

        echo "  ✓ Announcements seeded (2 items)\n";
    }
}
