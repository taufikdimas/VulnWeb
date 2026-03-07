<?php

require_once __DIR__ . '/../Seeder.php';

class UserSeeder extends Seeder
{

    public function run()
    {
        echo "  → Seeding users...\n";

        // Admin account
        $this->insert('users', [
            'username'        => 'admin',
            'email'           => 'admin@intracorp.local',
            'password'        => 'admin123', // Plain text password (vulnerability!)
            'full_name'       => 'System Administrator',
            'role'            => 'admin',
            'department'      => 'IT',
            'phone'           => '+62-812-3456-7890',
            'profile_picture' => null,
        ]);

        // Employee 1
        $this->insert('users', [
            'username'        => 'john.doe',
            'email'           => 'john.doe@intracorp.local',
            'password'        => 'employee123',
            'full_name'       => 'John Doe',
            'role'            => 'employee',
            'department'      => 'Finance',
            'phone'           => '+62-813-1111-2222',
            'profile_picture' => null,
        ]);

        // Employee 2
        $this->insert('users', [
            'username'        => 'jane.smith',
            'email'           => 'jane.smith@intracorp.local',
            'password'        => 'employee123',
            'full_name'       => 'Jane Smith',
            'role'            => 'employee',
            'department'      => 'HR',
            'phone'           => '+62-814-3333-4444',
            'profile_picture' => null,
        ]);

        // Employee 3
        $this->insert('users', [
            'username'        => 'bob.wilson',
            'email'           => 'bob.wilson@intracorp.local',
            'password'        => 'employee123',
            'full_name'       => 'Bob Wilson',
            'role'            => 'employee',
            'department'      => 'Marketing',
            'phone'           => '+62-815-5555-6666',
            'profile_picture' => null,
        ]);

        echo "  ✓ Users seeded (1 admin + 3 employees)\n";
    }
}
