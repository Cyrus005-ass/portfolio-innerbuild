<?php
$config = require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';

$email = 'Cyrusyoupassgba@gmail.com';
$stmt = $pdo->prepare("SELECT email, mot_de_passe_hash FROM admins WHERE email = ?");
$stmt->execute([$email]);
$admin = $stmt->fetch();

if ($admin) {
    echo "User found: " . $admin['email'] . "\n";
    echo "Hash match: " . (password_verify('Cyrus2005', $admin['mot_de_passe_hash']) ? 'YES' : 'NO') . "\n";
} else {
    echo "User NOT found: $email\n";
    // Check all admins
    $stmt = $pdo->query("SELECT email FROM admins");
    $all = $stmt->fetchAll();
    echo "Existing admins:\n";
    foreach ($all as $a) {
        echo "- " . $a['email'] . "\n";
    }
}
