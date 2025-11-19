<?php
// Script untuk generate password hash
// Jalankan file ini sekali untuk mendapatkan hash password yang benar

$password = 'pasya17';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: " . $password . "<br>";
echo "Hash: " . $hash . "<br><br>";

echo "Copy hash di atas dan update di database.sql atau langsung ke database:<br>";
echo "<pre>";
echo "UPDATE users SET password = '$hash' WHERE username = 'pasyaganteng';";
echo "</pre>";
