<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('APP_ADMIN_EMAIL', 'admin@example.com');
        $password = env('APP_ADMIN_PASSWORD', 'password');

        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);
            $this->command->info("Admin user created: $email");
        } else {
            $this->command->info("Admin user already exists: $email");
        }
    }
}
