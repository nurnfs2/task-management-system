<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch roles
        $adminRole = Role::where('name', 'Admin')->first();
        $userRole  = Role::where('name', 'User')->first();

        // Create Admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'email'    => 'admin@example.com',
                'role_id'  => $adminRole->id,
                'password' => Hash::make('123456'),
            ]
        );

        // Create regular User
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name'     => 'Regular User',
                'email'    => 'user@example.com',
                'role_id'  => $userRole->id,
                'password' => Hash::make('123456'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user2@example.com'],
            [
                'name'     => 'Regular User2',
                'email'    => 'user2@example.com',
                'role_id'  => $userRole->id,
                'password' => Hash::make('123456'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user3@example.com'],
            [
                'name'     => 'Regular User3',
                'email'    => 'user3@example.com',
                'role_id'  => $userRole->id,
                'password' => Hash::make('123456'),
            ]
        );


    }
}
