<?php
// FILE: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            TestUsersSeeder::class,
        ]);
    }
}

// FILE: database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@knott.co.za'],
            [
                'name' => 'Knott Admin',
                'email' => 'admin@knott.co.za',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $this->command->info('Admin user created: admin@knott.co.za / password');
    }
}

// FILE: database/seeders/TestUsersSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test vendor
        User::firstOrCreate(
            ['email' => 'vendor@test.com'],
            [
                'name' => 'Dream Events Photography',
                'email' => 'vendor@test.com',
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'email_verified_at' => now(),
                'is_active' => true,
                'bio' => 'Professional wedding photographer with 10 years of experience capturing beautiful moments.',
                'phone' => '+27 11 123 4567',
            ]
        );

        // Create test couple
        User::firstOrCreate(
            ['email' => 'couple@test.com'],
            [
                'name' => 'Sarah & Michael',
                'email' => 'couple@test.com',
                'password' => Hash::make('password'),
                'role' => 'couple',
                'email_verified_at' => now(),
                'is_active' => true,
                'bio' => 'Planning our dream garden wedding for March 2025!',
                'phone' => '+27 82 987 6543',
            ]
        );

        // Create test guest
        User::firstOrCreate(
            ['email' => 'guest@test.com'],
            [
                'name' => 'John Smith',
                'email' => 'guest@test.com',
                'password' => Hash::make('password'),
                'role' => 'guest',
                'email_verified_at' => now(),
                'is_active' => true,
                'bio' => 'Friend of the family, excited to support weddings!',
                'phone' => '+27 83 555 7890',
            ]
        );

        $this->command->info('Test users created:');
        $this->command->info('Vendor: vendor@test.com / password');
        $this->command->info('Couple: couple@test.com / password');
        $this->command->info('Guest: guest@test.com / password');
    }
}