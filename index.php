<?php
// index.php - Page de formulaire professionnel
session_start();

// Gestion de la soumission du formulaire
$message = '';
$type_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des données
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
    $sujet = htmlspecialchars(trim($_POST['sujet'] ?? ''));
    $message_contenu = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Validation basique
    $erreurs = [];
    
    if (empty($nom)) {
        $erreurs[] = "Le nom est requis";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Un email valide est requis";
    }
    
    if (empty($sujet)) {
        $erreurs[] = "Le sujet est requis";
    }
    
    if (empty($message_contenu)) {
        $erreurs[] = "Le message est requis";
    }

    if (count($erreurs) === 0) {
        // Simulation d'envoi
        $type_message = 'success';
        $message = "✓ Votre message a été envoyé avec succès! Nous vous répondrons dans les 24h.";
        
        // Ici vous pouvez ajouter la logique d'envoi d'email
        // mail($email, "Confirmation de réception", "Merci pour votre message...");
    } else {
        $type_message = 'error';
        $message = "✗ Erreurs detected: " . implode(", ", $erreurs);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Contact Professionnel</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <header class="header">
            <div class="logo-section">
                <img src="assets/images/logo.svg" alt="Logo" class="logo">
                <h1>Guerre Iran - Plateforme de Contact</h1>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class="main-content">
            <div class="form-container">
                <!-- Titre et description -->
                <div class="form-header">
                    <h2>Nous Contacter</h2>
                    <p>Remplissez le formulaire ci-dessous et nous vous répondrons rapidement.</p>
                </div>

                <!-- Message d'alerte -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $type_message; ?>">
                        <span class="alert-text"><?php echo $message; ?></span>
                        <button class="alert-close" onclick="this.parentElement.style.display='none';">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Formulaire -->
                <form action="index.php" method="POST" class="form-groupe" id="contactForm" novalidate>
                    
                    <!-- Champ Nom -->
                    <div class="form-field">
                        <label for="nom" class="form-label">
                            <i class="fas fa-user"></i> Nom Complet
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nom" 
                            name="nom" 
                            class="form-input" 
                            placeholder="Entrez votre nom complet"
                            required
                            value="<?php echo $_POST['nom'] ?? ''; ?>"
                        >
                        <small class="form-error" id="error-nom"></small>
                    </div>

                    <!-- Champ Email -->
                    <div class="form-field">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Adresse Email
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="votre.email@exemple.com"
                            required
                            value="<?php echo $_POST['email'] ?? ''; ?>"
                        >
                        <small class="form-error" id="error-email"></small>
                    </div>

                    <!-- Champ Téléphone -->
                    <div class="form-field">
                        <label for="telephone" class="form-label">
                            <i class="fas fa-phone"></i> Téléphone (Optionnel)
                        </label>
                        <input 
                            type="tel" 
                            id="telephone" 
                            name="telephone" 
                            class="form-input" 
                            placeholder="+33 6 XX XX XX XX"
                            value="<?php echo $_POST['telephone'] ?? ''; ?>"
                        >
                        <small class="form-hint">Format: +33 6 XX XX XX XX</small>
                    </div>

                    <!-- Champ Sujet -->
                    <div class="form-field">
                        <label for="sujet" class="form-label">
                            <i class="fas fa-tag"></i> Sujet
                            <span class="required">*</span>
                        </label>
                        <select id="sujet" name="sujet" class="form-input" required>
                            <option value="">-- Sélectionnez un sujet --</option>
                            <option value="information" <?php echo ($_POST['sujet'] ?? '') === 'information' ? 'selected' : ''; ?>>Demande d'information</option>
                            <option value="support" <?php echo ($_POST['sujet'] ?? '') === 'support' ? 'selected' : ''; ?>>Support technique</option>
                            <option value="reclamation" <?php echo ($_POST['sujet'] ?? '') === 'reclamation' ? 'selected' : ''; ?>>Réclamation</option>
                            <option value="partenariat" <?php echo ($_POST['sujet'] ?? '') === 'partenariat' ? 'selected' : ''; ?>>Partenariat</option>
                            <option value="autre" <?php echo ($_POST['sujet'] ?? '') === 'autre' ? 'selected' : ''; ?>>Autre</option>
                        </select>
                        <small class="form-error" id="error-sujet"></small>
                    </div>

                    <!-- Champ Message -->
                    <div class="form-field">
                        <label for="message" class="form-label">
                            <i class="fas fa-comment"></i> Message
                            <span class="required">*</span>
                        </label>
                        <textarea 
                            id="message" 
                            name="message" 
                            class="form-textarea" 
                            placeholder="Décrivez votre demande en détail..."
                            required
                            rows="6"
                        ><?php echo $_POST['message'] ?? ''; ?></textarea>
                        <div class="textarea-footer">
                            <small class="form-error" id="error-message"></small>
                            <small class="char-count"><span id="charCount">0</span>/500</small>
                        </div>
                    </div>

                    <!-- Checkboxes de consentement -->
                    <div class="form-field checkbox-field">
                        <label class="checkbox-label">
                            <input type="checkbox" name="conditions" required id="conditions">
                            <span>J'accepte les <a href="#" class="link">conditions d'utilisation</a></span>
                        </label>
                        <small class="form-error" id="error-conditions"></small>
                    </div>

                    <div class="form-field checkbox-field">
                        <label class="checkbox-label">
                            <input type="checkbox" name="newsletter" id="newsletter">
                            <span>Je souhaite recevoir les actualités par email</span>
                        </label>
                    </div>

                    <!-- Boutons -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Envoyer le message
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </button>
                    </div>

                    <!-- Texte informatif -->
                    <p class="form-info">
                        <i class="fas fa-info-circle"></i>
                        Les champs marqués avec <span class="required">*</span> sont obligatoires.
                    </p>
                </form>
            </div>

            <!-- Sidebar avec infos de contact -->
            <aside class="contact-sidebar">
                <div class="info-card">
                    <div class="info-header">
                        <i class="fas fa-headset"></i>
                        <h3>Besoin d'aide ?</h3>
                    </div>
                    <ul class="info-list">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Adresse</strong>
                                <p>123 Rue de la Paix, 75000 Paris</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <strong>Téléphone</strong>
                                <p><a href="tel:+33123456789">+33 1 23 45 67 89</a></p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <p><a href="mailto:contact@guerreiran.fr">contact@guerreiran.fr</a></p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Horaires</strong>
                                <p>Lun-Ven: 9h-18h<br>Sam: 10h-16h</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="info-card faq-card">
                    <h3>Questions Fréquentes</h3>
                    <ul class="faq-list">
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Comment accéder à mon compte ?</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Politique de confidentialité</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Moyens de paiement</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Délais de livraison</a></li>
                    </ul>
                </div>
            </aside>
        </main>

        <!-- Pied de page -->
        <footer class="footer">
            <p>&copy; 2026 Guerre Iran. Tous droits réservés.</p>
            <div class="social-links">
                <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
            </div>
        </footer>
    </div>

    <script src="assets/js/form-validation.js"></script>
</body>
</html>
