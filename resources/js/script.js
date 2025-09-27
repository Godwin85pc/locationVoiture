// Gestion de la soumission du formulaire
document.getElementById('reservation-form').addEventListener('submit', function(e) {
    e.preventDefault();
    let isValid = true;

    function validateField(fieldId, errorId, validationFn) {
        const field = document.getElementById(fieldId);
        const error = document.getElementById(errorId);

        if (!validationFn(field.value)) {
            field.classList.add('is-invalid');
            error.style.display = 'block';
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
            error.style.display = 'none';
        }
    }

    // Validation des champs
    validateField('lastName', 'lastName-error', v => v.trim() !== '');
    validateField('firstName', 'firstName-error', v => v.trim() !== '');
    validateField('email', 'email-error', v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v));
    validateField('phone', 'phone-error', v => v.trim() !== '');
    validateField('birthDate', 'birthDate-error', v => v.trim() !== '');
    validateField('address', 'address-error', v => v.trim() !== '');
    validateField('postalCode', 'postalCode-error', v => v.trim() !== '');
    validateField('city', 'city-error', v => v.trim() !== '');
    validateField('country', 'country-error', v => v !== '');

    validateField('password', 'password-error', v => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(v));

    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword');
    const confirmPasswordError = document.getElementById('confirmPassword-error');

    if (confirmPassword.value !== password) {
        confirmPassword.classList.add('is-invalid');
        confirmPasswordError.style.display = 'block';
        isValid = false;
    } else {
        confirmPassword.classList.remove('is-invalid');
        confirmPasswordError.style.display = 'none';
    }

    validateField('cardholder', 'cardholder-error', v => v.trim() !== '');
    validateField('cardNumber', 'cardNumber-error', v => v.replace(/\s/g, '').length === 16);
    validateField('expiryDate', 'expiryDate-error', v => /^(0[1-9]|1[0-2])\/([0-9]{2})$/.test(v));
    validateField('cvv', 'cvv-error', v => /^[0-9]{3,4}$/.test(v));

    const termsCheckbox = document.getElementById('terms');
    const termsError = document.getElementById('terms-error');

    if (!termsCheckbox.checked) {
        termsCheckbox.classList.add('is-invalid');
        termsError.style.display = 'block';
        isValid = false;
    } else {
        termsCheckbox.classList.remove('is-invalid');
        termsError.style.display = 'none';
    }

    if (isValid) {
        const submitBtn = document.querySelector('#reservation-form button[type="submit"]');
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Traitement en cours...';
        submitBtn.disabled = true;

        setTimeout(() => {
            alert('Paiement traité avec succès! Votre réservation est confirmée.');
            submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Réservation confirmée';
            submitBtn.classList.remove('btn-primary');
            submitBtn.classList.add('btn-success');

            document.getElementById('reservation-form').reset();
            document.getElementById('password-strength').style.backgroundColor = '';
        }, 2000);
    }
});

// Affichage erreurs temps réel
document.querySelectorAll('#reservation-form [required]').forEach(field => {
    field.addEventListener('blur', function() {
        this.classList.remove('is-invalid');
        const errorId = this.id + '-error';
        if (document.getElementById(errorId)) {
            document.getElementById(errorId).style.display = 'none';
        }
    });
});

// Force mot de passe
document.get
