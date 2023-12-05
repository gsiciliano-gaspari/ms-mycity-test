<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Crea Super Admin
        $superAdmin = User::create([
            'name' => env('SUPER_ADMIN_NAME'),
            'surname' => env('SUPER_ADMIN_SURNAME'),
            'username' => env('SUPER_ADMIN_USERNAME'),
            'email' => env('SUPER_ADMIN_EMAIL'),
            'phone' => env('SUPER_ADMIN_PHONE') ?? '',
            'password' => Hash::make(env('SUPER_ADMIN_PASSWORD'))
        ]);
        $superAdmin->assignRole('Super Admin');
        // Crea Admin
        $admin = User::create([
            'name' => env('ADMIN_NAME'),
            'surname' => env('ADMIN_SURNAME'),
            'username' => env('ADMIN_USERNAME'),
            'email' => env('ADMIN_EMAIL'),
            'phone' => env('ADMIN_PHONE') ?? '',
            'password' => Hash::make(env('ADMIN_PASSWORD'))
        ]);
        $admin->assignRole('Admin');
    }
}
