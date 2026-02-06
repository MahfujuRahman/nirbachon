<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ashon;
use App\Enums\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@nirbachon.com',
            'password' => Hash::make('password'),
            'role' => Roles::ADMIN,
        ]);

        // Create a default ashon
        Ashon::create([
            'title' => 'General Election 2026',
        ]);

        $this->command->info('Default admin created: admin@nirbachon.com / password');
    }
}
