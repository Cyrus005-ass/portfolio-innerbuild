<?php

/**
 * Fichier de connexion à la base de données
 * Utilise la configuration chargée dans $config
 */

if (!isset($config) || !is_array($config)) {
    $config = require __DIR__ . '/../config/config.php';
}

if (!isset($config['db'])) {
    die("Configuration de l'administration ou de la base de données introuvable.");
}

$dbConfig = $config['db'];

$dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['name']};charset={$dbConfig['charset']}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Récupère les données sous forme de tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false,            // Désactive l'émulation pour plus de sécurité (vraies requêtes préparées)
];

try {
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], $options);
} catch (\PDOException $e) {
    // En production, il vaut mieux cacher le vrai message d'erreur et le loguer
    error_log("Erreur PDO : " . $e->getMessage());
    die("Une erreur de connexion à la base de données est survenue.");
}
