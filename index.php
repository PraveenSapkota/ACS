<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <!-- Using Google reCAPTCHA v3 (code taken from V3 admin console) -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LfJjk8qAAAAAFVLaJOIJPCfCcYNOX7s8aWh9YcW"></script>

    <!-- Font Awesome for the Eye Icon(Used for pasword visibility) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <title>Registration Form</title>
</head>
<body>

    <!-- Main Registration Form Container -->
    <div class="container" id="container">
    
        <div class="form-container">
            <!-- Registration Form with validation -->
            <form id="registerForm" method="POST" action="registration.php" onsubmit="return validateForm();">
                <h1 class="h1">Register Now</h1>

                <!-- Email Input -->
                <input type="email" name="email" placeholder="Email" id="email" required>

                <!-- Username Input -->
                <input type="text" name="username" placeholder="Username" id="username" required>

                <!-- Password Input Section -->
                <div class="password-input-group">
                    <div class="password-input-container">
                        <input type="password" name="password" placeholder="Password" id="password" required>
                        <i id="togglePassword" class="fa fa-eye"></i>
                    </div>
                    <!-- Password Policies Container (Hidden until needed) -->
                </div>

                <div id="feedback"></div>

                <!-- Confirm Password Input with Eye Icon -->
                <div class="password-input-container">
                    <input type="password" name="confirmPassword" placeholder="Confirm Password" id="confirmPassword" required>
                    <i id="toggleConfirmPassword" class="fa fa-eye"></i>
                </div>

                <!-- Error Messages for Password Match and Validation -->
                <div id="matchMessage" style="color: red; display: none;"></div>
                <div id="errorMessage" style="color: red; display: none;"></div>

                <!-- Invisible reCAPTCHA v3 token -->
                <script>
                    // Google reCAPTCHA v3 Integration
                    grecaptcha.ready(function() {
                        grecaptcha.execute('6LfJjk8qAAAAAFVLaJOIJPCfCcYNOX7s8aWh9YcW', {action: 'submit'}).then(function(token) {
                            let recaptchaResponse = document.createElement('input');
                            recaptchaResponse.type = 'hidden';
                            recaptchaResponse.name = 'g-recaptcha-response';
                            recaptchaResponse.value = token;
                            document.forms[0].appendChild(recaptchaResponse);
                        });
                    });
                </script>

                <!-- Security Question Section(used as 3rd layer authentication)-->
                <label for="securityQuestion">Choose a Security Question:</label>
                <select id="securityQuestion" name="securityQuestion" required>
                    <option value="What was your childhood nickname?">What was your childhood nickname?</option>
                    <option value="What is your future goal/job?">What is your future goal/job?</option>
                    <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                    <option value="Your birthday month?">Your birthday month?</option>
                    <option value="What is your Favourite Food?">What is your Favourite Food?</option>
                </select>

                <!-- Security Answer Input -->
                <label for="securityAnswer">Your Answer:</label>
                <input type="text" id="securityAnswer" name="securityAnswer" required>

                <!-- Honeypot Field to Prevent Bots// hidden and only bot will input value in this field -->
                <div style="display:none;">
                    <label for="honeypot">Bot be AWare</label>
                    <input type="text" id="honeypot" name="honeypot" value="">
                </div>

                <!-- Submit Button -->
                <button type="submit" id="signUpButton">Sign Up</button>
            </form>
        </div>

        <!-- Password Policies Section for User Feedback -->
        <div id="passwordPolicies" class="password-policies">
            <p style="font-size: 17px;">Your password must include at least:</p>
            <ul>
                <li id="uppercase">At least one uppercase letter</li>
                <li id="lowercase">At least one lowercase letter</li>
                <li id="number">At least one number</li>
                <li id="specialChar">At least one special character (e.g. !@#$%)</li>
                <li id="minLength">Minimum 10 characters</li>
            </ul>
        </div>

    </div>

    <!-- Linking JavaScript File -->
    <script src="register.js"></script>

    
</body>
</html>
