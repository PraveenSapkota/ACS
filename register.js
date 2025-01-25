window.onload = function() {
    // ==== Element Selections ====
  
    const passInput = document.getElementById('password');
    const cPassInput = document.getElementById('confirmPassword');
    const matchMessage = document.getElementById('matchMessage'); // Ensure this exists in HTML
    const feedback = document.getElementById('feedback');
    

    // ==== Password Policies ====
    const passwordPolicies = document.getElementById('passwordPolicies');
    const uppercase = document.getElementById('uppercase');
    const lowercase = document.getElementById('lowercase');
    const number = document.getElementById('number');
    const specialChar = document.getElementById('specialChar');
    const minLength = document.getElementById('minLength');

    // ==== Event Listeners ====


    // Sign Up Button Click Event
    
    // Password Input Event: Check strength and display policies
    passInput.addEventListener('input', function () {
        const password = passInput.value;
        showPasswordPolicies();
        updatePasswordStrength(password);
        checkPasswordMatch(); // Check password match while typing
    });

    // Confirm Password Match Check
    cPassInput.addEventListener('input', function () {
        checkPasswordMatch();
    });

    

    
    // ==== Password Strength Functions ====

    // Function to show password policies
    function showPasswordPolicies() {
        passwordPolicies.style.display = 'block';
    }

    // Function to hide password policies
    function hidePasswordPolicies() {
        passwordPolicies.style.display = 'none';
    }

    // Function to check individual password policies
    function checkPasswordPolicies(password) {
        let isStrong = true;

        // Check for uppercase
        if (/[A-Z]/.test(password)) {
            uppercase.style.color = 'green';
        } else {
            uppercase.style.color = 'red';
            isStrong = false;
        }

        // Check for lowercase
        if (/[a-z]/.test(password)) {
            lowercase.style.color = 'green';
        } else {
            lowercase.style.color = 'red';
            isStrong = false;
        }

        // Check for number
        if (/[0-9]/.test(password)) {
            number.style.color = 'green';
        } else {
            number.style.color = 'red';
            isStrong = false;
        }

        // Check for special character
        if (/[^a-zA-Z0-9]/.test(password)) {
            specialChar.style.color = 'green';
        } else {
            specialChar.style.color = 'red';
            isStrong = false;
        }

        // Check for minimum length
        if (password.length >= 11) {
            minLength.style.color = 'green';
        } else {
            minLength.style.color = 'red';
            isStrong = false;
        }

        return isStrong;
    }

    // Function to update password strength
    function updatePasswordStrength(password) {
        let strength = '';
        const minLength = 6;
        const mediumLength = 10; 
        const feedback = document.getElementById('feedback'); 
    
        // Check if password policies are met (like numbers, special characters, etc.)
        const isStrong = checkPasswordPolicies(password);
    
        // Determine strength based on password length and policies
        if (password.length < minLength) {
            strength = 'Too short';
            feedback.style.color = 'red';
        } else if (password.length >= minLength && password.length < mediumLength) {
            strength = 'Weak';
            feedback.style.color = 'orange';
        } else if (password.length >= mediumLength && !isStrong) {
            strength = 'Medium';
            feedback.style.color = 'yellow';
        } else if (password.length >= mediumLength && isStrong) {
            strength = 'Strong';
            feedback.style.color = 'green';
            hidePasswordPolicies();
        }
    
        // Update the feedback element with password strength
        feedback.textContent = `Password Strength: ${strength}`;
    }
    

    // Function to check if passwords match
    function checkPasswordMatch() {
        if (passInput.value === cPassInput.value && cPassInput.value !== '') {
            matchMessage.style.color = 'green';
            matchMessage.textContent = 'Passwords Match';
        } else {
            matchMessage.style.color = 'red';
            matchMessage.textContent = 'Passwords Do Not Match';
        }
    }

    function validateVerificationForm() {
        let verificationCode = document.getElementById('verification_code').value;
        let verificationError = document.getElementById('verificationError');
        
        verificationError.style.display = 'none';

        if (verificationCode === '') {
            verificationError.style.display = 'block';
            verificationError.textContent = 'Please enter a valid verification code.';
            return false;
        }
        return true;
    }

            // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Change the eye icon accordingly
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Toggle confirm password visibility
        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);

            // Change the eye icon accordingly
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });


        


        function validateForm() {
            // Get password and confirm password fields
            let password = document.getElementById('password').value;
            let confirmPassword = document.getElementById('confirmPassword').value;

            // Get the match message and error message elements
            let matchMessage = document.getElementById('matchMessage');
            let errorMessage = document.getElementById('errorMessage');

            // Clear previous messages
            matchMessage.style.display = 'none';
            errorMessage.style.display = 'none';

            // Check if passwords match
            if (password !== confirmPassword) {
                matchMessage.style.display = 'block';
                matchMessage.textContent = 'Passwords do not match!';
                matchMessage.style.color = 'red';
                return false;  // Prevent form submission
            } else {
                matchMessage.style.display = 'block';
                matchMessage.textContent = 'Passwords match!';
                matchMessage.style.color = 'green';
            }

            // Return true if everything is correct
            return true;
        }

        // Real-time password match check while typing
        document.getElementById('password').addEventListener('input', validateForm);
        document.getElementById('confirmPassword').addEventListener('input', validateForm);

};
