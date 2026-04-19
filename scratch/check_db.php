<?php
$config = require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';

try {
    $stmt = $pdo->query("DESCRIBE projets");
    $columns = $stmt->fetchAll();
    echo "Columns in 'projets':\n";
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }

    $stmt = $pdo->query("DESCRIBE profil");
    $columns = $stmt->fetchAll();
    echo "\nColumns in 'profil':\n";
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
    
    $stmt = $pdo->query("DESCRIBE certifications");
    $columns = $stmt->fetchAll();
    echo "\nColumns in 'certifications':\n";
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
