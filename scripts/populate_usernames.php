<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;

// Populate username from email local-part for null usernames
DB::statement("UPDATE users SET username = substr(email,1, instr(email,'@')-1) WHERE username IS NULL;");

// Fix duplicates by appending user id
$dups = DB::select("SELECT username, COUNT(*) as c FROM users GROUP BY username HAVING c>1");
foreach ($dups as $d) {
    $rows = User::where('username', $d->username)->get();
    foreach ($rows as $r) {
        $r->username = $r->username . '_' . $r->id;
        $r->save();
    }
}

echo "populate_usernames done\n";
