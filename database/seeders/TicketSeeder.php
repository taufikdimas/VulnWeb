<?php

require_once __DIR__ . '/../Seeder.php';

class TicketSeeder extends Seeder
{

    public function run()
    {
        echo "  → Seeding tickets...\n";

        $this->insert('tickets', [
            'user_id'  => 2,
            'subject'  => 'Cannot access email',
            'message'  => 'I am unable to login to my company email account. Please help.',
            'status'   => 'open',
            'priority' => 'high',
        ]);

        $this->insert('tickets', [
            'user_id'  => 3,
            'subject'  => 'Printer not working',
            'message'  => 'The printer on 3rd floor is showing error message.',
            'status'   => 'in_progress',
            'priority' => 'medium',
        ]);

        $this->insert('tickets', [
            'user_id'  => 4,
            'subject'  => 'Request new laptop',
            'message'  => 'My current laptop is very slow. I need a new one for better productivity.',
            'status'   => 'closed',
            'priority' => 'low',
        ]);

        echo "  ✓ Tickets seeded (3 items)\n";
    }
}
