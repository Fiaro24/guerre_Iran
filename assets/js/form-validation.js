// ============================================
// VALIDATION DU FORMULAIRE
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    
    if (form) {
        // Initialisation
        initCharCounter();
        setupEventListeners();
        
        // Soumission du formulaire
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }
});

// ============================================
// SETUP DES EVENT LISTENERS
// ============================================

function setupEventListeners() {
    // Champ Nom
    document.getElementById('nom')?.addEventListener('blur', () => {
        validateField('nom', /^[a-zA-Z\s\-']{2,}$/, 'Entrez un nom valide');
    });

    // Champ Email
    document.getElementById('email')?.addEventListener('blur', () => {
        validateEmail();
    });

    // Champ Téléphone
    document.getElementById('telephone')?.addEventListener('blur', () => {
        validateTelephone();
    });

    // Champ Sujet
    document.getElementById('sujet')?.addEventListener('change', () => {
        validateField('sujet', /.+/, 'Veuillez sélectionner un sujet');
    });

    // Champ Message
    document.getElementById('message')?.addEventListener('input', function() {
        updateCharCounter();
        validateField('message', /.+/, 'Le message ne peut pas être vide');
    });

    // Checkboxes
    document.getElementById('conditions')?.addEventListener('change', function() {
        const error = document.getElementById('error-conditions');
        if (!this.checked) {
            if (error) error.textContent = 'Vous devez accepter les conditions';
            if (error) error.classList.add('show');
        } else {
            if (error) error.classList.remove('show');
        }
    });
}

// ============================================
// VALIDATION DE FORMULAIRE
// ============================================

function validateForm() {
    clearErrors();
    let isValid = true;

    // Validation Nom
    if (!validateField('nom', /^[a-zA-Z\s\-']{2,}$/, 'Entrez un nom valide (minimum 2 caractères)')) {
        isValid = false;
    }

    // Validation Email
    if (!validateEmail()) {
        isValid = false;
    }

    // Validation Sujet
    if (!validateField('sujet', /.+/, 'Veuillez sélectionner un sujet')) {
        isValid = false;
    }

    // Validation Message
    if (!validateField('message', /.{10,}/, 'Le message doit contenir au moins 10 caractères')) {
        isValid = false;
    }

    // Validation Conditions
    const conditions = document.getElementById('conditions');
    if (!conditions.checked) {
        const error = document.getElementById('error-conditions');
        if (error) {
            error.textContent = 'Vous devez accepter les conditions d\'utilisation';
            error.classList.add('show');
        }
        isValid = false;
    }

    // Afficher le message de statut
    if (isValid) {
        displayFormStatus('success', 'Formulaire valide! Envoi en cours...');
    } else {
        displayFormStatus('error', 'Veuillez corriger les erreurs ci-dessus.');
    }

    return isValid;
}

// ============================================
// VALIDATION DE CHAMP GÉNÉRIQUE
// ============================================

function validateField(fieldId, regex, errorMessage) {
    const field = document.getElementById(fieldId);
    const errorElement = document.getElementById(`error-${fieldId}`);
    
    if (!field || !errorElement) return true;

    const value = field.value.trim();
    const isValid = regex.test(value);

    if (!isValid && value !== '') {
        errorElement.textContent = errorMessage;
        errorElement.classList.add('show');
        field.classList.add('error');
        field.classList.remove('success');
    } else if (value === '') {
        errorElement.textContent = 'Ce champ est requis';
        errorElement.classList.add('show');
        field.classList.add('error');
        field.classList.remove('success');
    } else {
        errorElement.classList.remove('show');
        field.classList.remove('error');
        field.classList.add('success');
    }

    return isValid || value === '';
}

// ============================================
// VALIDATION EMAIL
// ============================================

function validateEmail() {
    const email = document.getElementById('email');
    const errorElement = document.getElementById('error-email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    const isValid = emailRegex.test(email.value);

    if (!isValid && email.value !== '') {
        errorElement.textContent = 'Entrez une adresse email valide';
        errorElement.classList.add('show');
        email.classList.add('error');
        email.classList.remove('success');
        return false;
    } else if (email.value === '') {
        errorElement.textContent = 'Ce champ est requis';
        errorElement.classList.add('show');
        email.classList.add('error');
        email.classList.remove('success');
        return false;
    } else {
        errorElement.classList.remove('show');
        email.classList.remove('error');
        email.classList.add('success');
        return true;
    }
}

// ============================================
// VALIDATION TÉLÉPHONE
// ============================================

function validateTelephone() {
    const telephone = document.getElementById('telephone');
    const errorElement = document.getElementById('error-telephone');
    
    if (telephone.value === '') {
        // Le champ est optionnel
        if (errorElement) errorElement.classList.remove('show');
        telephone.classList.remove('error');
        return true;
    }

    const phoneRegex = /^[\d\s\-\+\(\)]{9,}$/;
    const isValid = phoneRegex.test(telephone.value);

    if (!isValid) {
        if (errorElement) {
            errorElement.textContent = 'Entrez un numéro de téléphone valide';
            errorElement.classList.add('show');
        }
        telephone.classList.add('error');
    } else {
        if (errorElement) errorElement.classList.remove('show');
        telephone.classList.remove('error');
    }

    return isValid;
}

// ============================================
// COMPTEUR DE CARACTÈRES
// ============================================

function initCharCounter() {
    const messageField = document.getElementById('message');
    if (messageField) {
        messageField.setAttribute('maxlength', '500');
    }
}

function updateCharCounter() {
    const messageField = document.getElementById('message');
    const charCount = document.getElementById('charCount');
    
    if (messageField && charCount) {
        charCount.textContent = messageField.value.length;
    }
}

// ============================================
// UTILITAIRES
// ============================================

function clearErrors() {
    const errorElements = document.querySelectorAll('.form-error');
    const inputs = document.querySelectorAll('.form-input, .form-textarea');
    
    errorElements.forEach(el => el.classList.remove('show'));
    inputs.forEach(input => {
        input.classList.remove('error');
        input.classList.remove('success');
    });
}

function displayFormStatus(type, message) {
    // Optionnel: afficher un message de statut
    console.log(`[${type.toUpperCase()}] ${message}`);
}

// ============================================
// ANIMATIONS SMOOTH SCROLL
// ============================================

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && document.querySelector(href)) {
            e.preventDefault();
            document.querySelector(href).scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ============================================
// DÉTECTION DES MODIFICATIONS
// ============================================

const form = document.getElementById('contactForm');
if (form) {
    let isDirty = false;

    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            isDirty = true;
        });
    });

    // Avertir avant de quitter si le formulaire a été modifié
    window.addEventListener('beforeunload', (e) => {
        if (isDirty && form.innerHTML !== '') {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Réinitialiser le flag après envoi
    form.addEventListener('submit', () => {
        isDirty = false;
    });
}
