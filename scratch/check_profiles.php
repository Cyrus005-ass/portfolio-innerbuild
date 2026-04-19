<?php
$config = require __DIR__ . '/../src/config/config.php';
require __DIR__ . '/../src/includes/db.php';

$stmt = $pdo->query("SELECT id, nom, email_contact, avatar FROM profil");
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($profiles, JSON_PRETTY_PRINT);
