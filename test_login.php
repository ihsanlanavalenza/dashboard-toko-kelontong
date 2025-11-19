<?php
session_start();
require_once 'config.php';

echo "<h2>Test Login Debug</h2>";
echo "<hr>";

// Test 1: Database Connection
echo "<h3>1. Database Connection</h3>";
if ($conn) {
    echo "✓ Database connected<br>";
} else {
    echo "✗ Database connection failed<br>";
}

// Test 2: Check User
echo "<h3>2. Check User 'pasyaganteng'</h3>";
$query = "SELECT * FROM users WHERE username = 'pasyaganteng'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "✓ User found<br>";
    echo "Username: " . $user['username'] . "<br>";
    echo "Nama: " . $user['nama_lengkap'] . "<br>";
    echo "Password hash (first 20 chars): " . substr($user['password'], 0, 20) . "...<br>";
} else {
    echo "✗ User not found<br>";
}

// Test 3: Password Verify
echo "<h3>3. Password Verification</h3>";
$test_password = 'pasya17';
if (isset($user)) {
    if (password_verify($test_password, $user['password'])) {
        echo "✓ Password verified successfully<br>";
    } else {
        echo "✗ Password verification failed<br>";
        echo "Testing plaintext match: " . ($test_password === 'pasya17' ? '✓ Plain match works' : '✗ No match') . "<br>";
    }
}

// Test 4: Session Test
echo "<h3>4. Session Test</h3>";
$_SESSION['test'] = 'Session works!';
if (isset($_SESSION['test'])) {
    echo "✓ Session is working<br>";
    echo "Session value: " . $_SESSION['test'] . "<br>";
} else {
    echo "✗ Session not working<br>";
}

// Test 5: Manual Login Test
echo "<h3>5. Manual Login Simulation</h3>";
if (isset($user)) {
    $_SESSION['user_id'] = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
    $_SESSION['role'] = $user['role'];

    echo "✓ Session variables set:<br>";
    echo "- user_id: " . $_SESSION['user_id'] . "<br>";
    echo "- username: " . $_SESSION['username'] . "<br>";
    echo "- nama_lengkap: " . $_SESSION['nama_lengkap'] . "<br>";
    echo "- role: " . $_SESSION['role'] . "<br>";

    echo "<br><a href='dashboard.php' style='padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px;'>Test Dashboard Access</a>";
}

echo "<hr>";
echo "<a href='login.php'>Back to Login</a>";
