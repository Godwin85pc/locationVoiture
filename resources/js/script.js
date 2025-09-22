document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reservation-form');
    if (!form) return;

    let formSubmitted = false;

    const fields = [
        'lastName', 'firstName', 'email', 'phone', 'birthDate',
        'address', 'postalCode', 'city', 'country',
        'password', 'confirmPassword', 'cardholder', 'cardNumber', 'expiryDate', 'cvv', 'terms'
    ];

    function showError(inputId, message) {
        const input = document.getElementById(inputId);
        const errorDiv = document.getElementById(`${inputId}-error`);
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }
        if (input) input.classList.add('is-invalid');
    }

    function hideError(inputId) {
        const input = document.getElementById(inputId);
        const errorDiv = document.getElementById(`${inputId}-error`);
        if (errorDiv) errorDiv.style.display = 'none';
        if (input) input.classList.remove('is-invalid');
    }

    function validateField(fieldId) {
        const input = document.getElementById(fieldId);
        switch(fieldId) {
            case 'email':
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
                    showError(fieldId, 'Veuillez saisir une adresse email valide.');
                } else {
                    hideError(fieldId);
                }
                break;
            case 'password':
                if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(input.value)) {
                    showError(fieldId, 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.');
                } else {
                    hideError(fieldId);
                }
                break;
            case 'confirmPassword':
                const password = document.getElementById('password').value;
                if (input.value !== password) {
                    showError(fieldId, 'Les mots de passe ne correspondent pas.');
                } else {
                    hideError(fieldId);
                }
                break;
            case 'cardNumber':
                if (input.value.replace(/\s/g, '').length !== 16) {
                    showError(fieldId, 'Veuillez saisir un numéro de carte valide.');
                } else {
                    hideError(fieldId);
                }
                break;
            case 'expiryDate':
                if (!/^(0[1-9]|1[0-2])\/([0-9]{2})$/.test(input.value)) {
                    showError(fieldId, 'Veuillez saisir la date d\'expiration au format MM/AA.');
                } else {
                    hideError(fieldId);
                }
                break;
            case 'cvv':
                if (!/^[0-9]{3,4}$/.test(input.value)) {
                    showError(fieldId, 'Veuillez saisir le code CVV.');
                } else {
                    hideError(fieldId);
                }
                break;
            case 'terms':
                if (!input.checked) {
                    showError(fieldId, 'Vous devez accepter les conditions générales pour continuer.');
                } else {
                    hideError(fieldId);
                }
                break;
            default:
                if (input.value.trim() === '') {
                    showError(fieldId, 'Veuillez remplir ce champ.');
                } else {
                    hideError(fieldId);
                }
        }
    }

    // Password strength bar
    const password = document.getElementById('password');
    const passwordStrength = document.getElementById('password-strength');

    if (password && passwordStrength) {
        password.addEventListener('input', function() {
            const pass = this.value;
            let strength = 0;
            if(pass.length >= 8) strength++;
            if(/[A-Z]/.test(pass)) strength++;
            if(/[a-z]/.test(pass)) strength++;
            if(/\d/.test(pass)) strength++;
            switch(strength) {
                case 0:
                    passwordStrength.style.background = '#dc3545';
                    passwordStrength.style.width = '0%';
                    break;
                case 1:
                    passwordStrength.style.background = '#dc3545';
                    passwordStrength.style.width = '25%';
                    break;
                case 2:
                    passwordStrength.style.background = '#fd7e14';
                    passwordStrength.style.width = '50%';
                    break;
                case 3:
                    passwordStrength.style.background = '#ffc107';
                    passwordStrength.style.width = '75%';
                    break;
                case 4:
                    passwordStrength.style.background = '#198754';
                    passwordStrength.style.width = '100%';
                    break;
            }
        });
    }

    // Validation à la soumission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        formSubmitted = true;
        let valid = true;

        fields.forEach(field => {
            const input = document.getElementById(field);
            if(field === 'terms') {
                if(!input.checked) {
                    showError(field, 'Vous devez accepter les conditions générales pour continuer.');
                    valid = false;
                } else {
                    hideError(field);
                }
            } else if(input && input.value.trim() === '') {
                showError(field, 'Veuillez remplir ce champ.');
                valid = false;
            } else {
                validateField(field);
                if (document.getElementById(`${field}-error`).style.display === 'block') {
                    valid = false;
                }
            }
        });

        if(valid) {
            const submitBtn = document.querySelector('#reservation-form button[type="submit"]');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Traitement en cours...';
            submitBtn.disabled = true;

            setTimeout(() => {
                alert('Paiement traité avec succès! Votre réservation est confirmée.');
                submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Réservation confirmée';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-success');
                form.reset();
                if(passwordStrength) {
                    passwordStrength.style.width = '0%';
                    passwordStrength.style.backgroundColor = '';
                }
                formSubmitted = false;
            }, 2000);
        }
    });
});