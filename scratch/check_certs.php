<?php
$config = require __DIR__ . '/../src/config/config.php';
require __DIR__ . '/../src/includes/db.php';

$stmt = $pdo->query("DESCRIBE certifications");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($columns, JSON_PRETTY_PRINT);
