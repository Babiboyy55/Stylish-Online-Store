<?php
$base = 'http://127.0.0.1:8000';
$cookieFile = __DIR__ . '/cookies.txt';
if (file_exists($cookieFile)) unlink($cookieFile);
$ch = curl_init($base . '/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
$html = curl_exec($ch);
curl_close($ch);
if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $html, $m)) {
    $token = $m[1];
} else {
    $token = '';
}
echo "csrf: $token\n";
// Post login
$ch = curl_init($base . '/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$postFields = http_build_query(['login' => 'admin@example.com', 'password' => 'password', '_token' => $token]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
curl_close($ch);
echo "Login HTTP code: $http_code\n";
if (preg_match('/Location: (.*)\r\n/', $header, $m)) {
    echo "Location: " . trim($m[1]) . "\n";
}
// Now request /admin
$ch = curl_init($base . '/admin');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$admin = curl_exec($ch);
$admin_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "Admin HTTP code: $admin_code\n";
if ($admin_code == 200) {
    echo "Admin content snippet: \n" . substr($admin, 0, 500) . "\n";
}
