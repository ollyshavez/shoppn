document.addEventListener('DOMContentLoaded', function () {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9+\-\s]{7,15}$/;
    const passwordRegex = /^(?=.*\d).{8,}$/;

    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        if (errorElement) {
            errorElement.innerText = message;
            errorElement.style.display = 'block';
        }
    }

    function clearErrors() {
        const errors = document.querySelectorAll('.error-text');
        errors.forEach(function (el) {
            el.innerText = '';
            el.style.display = 'none';
        });
    }

    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            clearErrors();
            let valid = true;

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const pass = document.getElementById('pass').value;
            const confirmPass = document.getElementById('confirm_pass').value;
            const country = document.getElementById('country').value.trim();
            const city = document.getElementById('city').value.trim();
            const contact = document.getElementById('contact').value.trim();

            if (name.length < 2) {
                showError('name-error', 'Please enter your full name (at least 2 characters).');
                valid = false;
            } else if (name.length > 100) {
                showError('name-error', 'Name cannot exceed 100 characters.');
                valid = false;
            }

            if (!emailRegex.test(email)) {
                showError('email-error', 'Please enter a valid email address.');
                valid = false;
            } else if (email.length > 50) {
                showError('email-error', 'Email cannot exceed 50 characters.');
                valid = false;
            }

            if (!passwordRegex.test(pass)) {
                showError('pass-error', 'Password must be at least 8 characters long and contain at least one digit.');
                valid = false;
            }

            if (pass !== confirmPass) {
                showError('confirm-pass-error', 'Passwords do not match.');
                valid = false;
            }

            if (country.length === 0) {
                showError('country-error', 'Please select or enter your country.');
                valid = false;
            }

            if (city.length === 0) {
                showError('city-error', 'Please enter your city.');
                valid = false;
            }

            if (!phoneRegex.test(contact)) {
                showError('contact-error', 'Please enter a valid phone number (7-15 digits, +, - allowed).');
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    }

    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            clearErrors();
            let valid = true;

            const email = document.getElementById('login-email').value.trim();
            const pass = document.getElementById('login-pass').value;

            if (!emailRegex.test(email)) {
                showError('login-email-error', 'Please enter a valid email address.');
                valid = false;
            }

            if (pass.length === 0) {
                showError('login-pass-error', 'Please enter your password.');
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    }
});
