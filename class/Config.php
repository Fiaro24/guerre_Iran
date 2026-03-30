<?php
/**
 * Configuration Application
 * 
 * Fichier de configuration centralisée pour l'application
 * Contient les paramètres de base et les fonctions utiles
 */

// Configuration de base
define('APP_NAME', 'Guerre Iran');
define('APP_VERSION', '1.0.0');
define('APP_AUTHOR', 'Mr Rojo');

// Configuration email
define('ADMIN_EMAIL', 'contact@guerreiran.fr');
define('SUPPORT_EMAIL', 'support@guerreiran.fr');
define('REPLY_TO_EMAIL', 'noreply@guerreiran.fr');

// Configuration de sécurité
define('MAX_MESSAGE_LENGTH', 500);
define('MIN_NAME_LENGTH', 2);
define('MIN_MESSAGE_LENGTH', 10);

// Configuration de stockage (préparation BD)
define('STORAGE_TYPE', 'file'); // 'file', 'database', 'email'
define('STORAGE_PATH', __DIR__ . '/data/');

// Configuration du formulaire
$FORM_SUBJECTS = [
    'information' => 'Demande d\'information',
    'support' => 'Support technique',
    'reclamation' => 'Réclamation',
    'partenariat' => 'Partenariat',
    'autre' => 'Autre'
];

/**
 * Fonction de validation email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Fonction de validation téléphone
 */
function isValidPhone($phone) {
    // Accepte les formats: +33612345678, 06 12 34 56 78, 06-12-34-56-78, etc.
    $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
    return preg_match('/^[\d\+]{9,}$/', $phone);
}

/**
 * Fonction de sanitization
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Fonction de validation de formulaire
 */
function validateContactForm($data) {
    $errors = [];
    
    // Validation nom
    if (empty($data['nom'])) {
        $errors['nom'] = 'Le nom est requis';
    } elseif (strlen($data['nom']) < MIN_NAME_LENGTH) {
        $errors['nom'] = 'Le nom doit contenir au moins ' . MIN_NAME_LENGTH . ' caractères';
    }
    
    // Validation email
    if (empty($data['email'])) {
        $errors['email'] = 'L\'email est requis';
    } elseif (!isValidEmail($data['email'])) {
        $errors['email'] = 'Veuillez entrer une adresse email valide';
    }
    
    // Validation téléphone (optionnel)
    if (!empty($data['telephone']) && !isValidPhone($data['telephone'])) {
        $errors['telephone'] = 'Le numéro de téléphone n\'est pas valide';
    }
    
    // Validation sujet
    if (empty($data['sujet'])) {
        $errors['sujet'] = 'Veuillez sélectionner un sujet';
    }
    
    // Validation message
    if (empty($data['message'])) {
        $errors['message'] = 'Le message est requis';
    } elseif (strlen($data['message']) < MIN_MESSAGE_LENGTH) {
        $errors['message'] = 'Le message doit contenir au moins ' . MIN_MESSAGE_LENGTH . ' caractères';
    } elseif (strlen($data['message']) > MAX_MESSAGE_LENGTH) {
        $errors['message'] = 'Le message ne doit pas dépasser ' . MAX_MESSAGE_LENGTH . ' caractères';
    }
    
    // Validation conditions
    if (empty($data['conditions'])) {
        $errors['conditions'] = 'Vous devez accepter les conditions d\'utilisation';
    }
    
    return $errors;
}

/**
 * Fonction de sauvegarde des données
 */
function saveContactData($data) {
    // Créer le dossier de stockage s'il n'existe pas
    if (!is_dir(STORAGE_PATH)) {
        mkdir(STORAGE_PATH, 0755, true);
    }
    
    // Préparer les données
    $contact = [
        'id' => uniqid('contact_', true),
        'timestamp' => date('Y-m-d H:i:s'),
        'nom' => sanitizeInput($data['nom']),
        'email' => sanitizeInput($data['email']),
        'telephone' => sanitizeInput($data['telephone'] ?? ''),
        'sujet' => sanitizeInput($data['sujet']),
        'message' => sanitizeInput($data['message']),
        'newsletter' => !empty($data['newsletter']) ? 1 : 0,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ];
    
    // Sauvegarder en JSON
    $filename = STORAGE_PATH . 'contact_' . $contact['id'] . '.json';
    file_put_contents($filename, json_encode($contact, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    return $contact;
}

/**
 * Fonction d'envoi d'email (à implémenter)
 */
function sendConfirmationEmail($email, $nom, $contact_id) {
    $subject = "Confirmation de réception - " . APP_NAME;
    $message = "Bonjour $nom,\n\n";
    $message .= "Nous avons bien reçu votre message.\n";
    $message .= "Notre équipe vous répondra dans les 24 heures.\n\n";
    $message .= "Numéro de dossier: $contact_id\n\n";
    $message .= "Cordialement,\nL'équipe " . APP_NAME;
    
    $headers = "From: " . REPLY_TO_EMAIL . "\r\n";
    $headers .= "Reply-To: " . SUPPORT_EMAIL . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Décommenter pour activer l'envoi d'email
    // return mail($email, $subject, $message, $headers);
    
    return true; // Pour développement
}

/**
 * Fonction de log
 */
function logEvent($type, $message, $data = []) {
    $log_dir = __DIR__ . '/logs/';
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $log_file = $log_dir . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] [$type] $message";
    
    if (!empty($data)) {
        $log_message .= " - " . json_encode($data);
    }
    
    error_log($log_message . "\n", 3, $log_file);
}
?>
