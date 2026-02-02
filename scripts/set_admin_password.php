<?php
// Local helper: create or update admin user with password 'admin'
// Usage: php scripts/set_admin_password.php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

if (! app()->environment('local')) {
    echo "This script can only be run in local environment.\n";
    exit(1);
}

$email = 'admin@example.com';
$username = 'admin';
$password = 'admin';

$user = User::where('email', $email)->first();
if (! $user) {
    $user = User::create([
        'name' => 'Administrator',
        'username' => $username,
        'email' => $email,
        'password' => Hash::make($password),
        'is_admin' => true,
    ]);
    echo "Created admin user: {$email}\n";
} else {
    $user->password = Hash::make($password);
    $user->is_admin = true;
    $user->username = $username;
    $user->save();
    echo "Updated admin user password to 'admin' for: {$email}\n";
}

echo "Done. You can now login with email: {$email} and password: {$password}\n";
