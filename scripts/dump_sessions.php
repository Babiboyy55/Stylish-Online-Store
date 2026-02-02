<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pdo = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
$stmt = $pdo->query("SELECT id, user_id, ip_address, last_activity FROM sessions ORDER BY last_activity DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!count($rows)) {
    echo "No sessions found.\n";
    exit(0);
}
foreach ($rows as $r) {
    echo "id: " . $r['id'] . " | user_id: " . ($r['user_id'] ?? 'NULL') . " | ip: " . ($r['ip_address'] ?? '') . " | last_activity: " . $r['last_activity'] . "\n";
}
