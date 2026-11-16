<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $roles = [
            ['name' => 'Administrator', 'guard_name' => 'web', 'description' => 'Admin dengan akses penuh'],
            ['name' => 'Operator', 'guard_name' => 'web', 'description' => 'Operator yang mengelola data'],
            ['name' => 'Peneliti', 'guard_name' => 'web', 'description' => 'Peneliti yang mengakses data analitik'],
            ['name' => 'Masyarakat', 'guard_name' => 'web', 'description' => 'Pengguna umum masyarakat'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Create Admin User
        User::create([
            'name' => 'Admin WeatherLive',
            'email' => 'admin@weatherlive.id',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
            'phone' => '081234567890',
            'is_active' => true,
            'timezone' => 'Asia/Jakarta',
        ]);

        // Create Operator User
        User::create([
            'name' => 'Operator BMKG',
            'email' => 'operator@weatherlive.id',
            'password' => Hash::make('operator123'),
            'role_id' => 2,
            'phone' => '081234567891',
            'is_active' => true,
            'timezone' => 'Asia/Jakarta',
        ]);

        // Create Masyarakat User (demo)
        User::create([
            'name' => 'Masyarakat Umum',
            'email' => 'user@weatherlive.id',
            'password' => Hash::make('user1234'),
            'role_id' => 4,
            'phone' => '081234567892',
            'is_active' => true,
            'timezone' => 'Asia/Jakarta',
        ]);

        // Seed all Indonesia regions (38 provinces, 100+ cities, 150+ districts, 100+ villages)
        $this->call(IndonesiaRegionsSeeder::class);
        $this->call(WeatherStationAndSensorSeeder::class);

        echo "Database seeded successfully!\n";
        echo "Admin: admin@weatherlive.id / admin123\n";
        echo "Operator: operator@weatherlive.id / operator123\n";
        echo "User: user@weatherlive.id / user1234\n";
    }
}
