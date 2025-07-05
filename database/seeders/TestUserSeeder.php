<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create test user with known username and PIN for easy testing
        User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('dummy'),
            'pin' => Hash::make('1234'), // PIN: 1234
            'pin_generated_at' => now(),
            'is_active' => true,
        ]);

        // Create another test user
        User::create([
            'name' => 'Demo User',
            'username' => 'demo',
            'email' => 'demo@example.com',
            'password' => Hash::make('dummy'),
            'pin' => Hash::make('5678'), // PIN: 5678
            'pin_generated_at' => now(),
            'is_active' => true,
        ]);

        echo "✅ Test users created:\n";
        echo "👤 Username: testuser, PIN: 1234\n";
        echo "👤 Username: demo, PIN: 5678\n";
        echo "🔐 Master login: username 'master' with PIN from .env\n";
    }
}
