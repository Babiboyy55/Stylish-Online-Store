<?php
$db = __DIR__ . '/../database/database.sqlite';
if (!file_exists($db)) { echo "DB missing\n"; exit(1); }
$pdo = new PDO('sqlite:' . $db);
$rows = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
foreach ($rows as $r) echo $r . "\n";
