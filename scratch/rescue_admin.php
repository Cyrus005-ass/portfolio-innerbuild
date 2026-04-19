<?php
$config = require __DIR__ . '/../src/config/config.php';
require __DIR__ . '/../src/includes/db.php';

$email = 'cyrusyoupassogba@gmail.com';
$password = 'Cyrus2005';
$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    // Delete potential typos
    $pdo->prepare("DELETE FROM admins WHERE email LIKE 'cyrusyou%'")->execute();
    
    // Insert correct one
    $stmt = $pdo->prepare("INSERT INTO admins (email, mot_de_passe_hash, role) VALUES (?, ?, 'superadmin')");
    $stmt->execute([$email, $hash]);
    
    echo "SUCCESS: Admin created with email: $email and password: $password\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
