<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$products = \App\Models\Product::all();

echo "=== ALL PRODUCTS IMAGE PATHS ===" . PHP_EOL . PHP_EOL;

foreach ($products as $p) {
    echo "ID: " . $p->id . " | " . $p->name . PHP_EOL;
    echo "  Image: " . ($p->image ?? 'NULL') . PHP_EOL;
    echo PHP_EOL;
}
