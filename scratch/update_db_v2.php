<?php
$config = require __DIR__ . '/../src/config/config.php';
require __DIR__ . '/../src/includes/db.php';

try {
    // Rename twitter to instagram
    $pdo->exec("ALTER TABLE profil CHANGE twitter instagram VARCHAR(255)");
    echo "SUCCESS: Column 'twitter' renamed to 'instagram'.\n";
} catch (Exception $e) {
    echo "INFO: Column 'twitter' might already be renamed or missing: " . $e->getMessage() . "\n";
}
