<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::all(['id','username','email','is_admin']);
foreach ($users as $u) {
    echo $u->id . ' | ' . $u->username . ' | ' . $u->email . ' | is_admin: ' . ($u->is_admin ? '1' : '0') . "\n";
}
