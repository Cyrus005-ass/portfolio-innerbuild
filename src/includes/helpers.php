<?php
/**
 * Helpers - Fonctions utilitaires globales
 */

/**
 * Échappe les balises HTML pour prévenir les failles XSS
 * Version courte pour un usage intensif dans les templates
 */
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Génère un lien WhatsApp propre
 */
function getWhatsAppLink($phone, $text = "") {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return "https://wa.me/{$phone}" . (!empty($text) ? "?text=" . urlencode($text) : "");
}

/**
 * Formate une date de manière lisible
 */
function formatDate($date, $format = 'M Y') {
    if (empty($date)) return '';
    return date($format, strtotime($date));
}
