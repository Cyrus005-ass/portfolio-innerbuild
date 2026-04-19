<?php
$config = require __DIR__ . '/../src/config/config.php';
require __DIR__ . '/../src/includes/db.php';

$stmt = $pdo->query("DESCRIBE profil");
$columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo json_encode($columns);
