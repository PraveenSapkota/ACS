<?php
session_start();

// Including the AES encryption class for email encryption
require 'encryption.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Getting the verification code entered by the user
    $enteredCode = $_POST['verification_code'];

    // Check if the OTP has expired(time more than >100sec is expired)
    if (time() > $_SESSION['otp_expiration']) {
        echo "<script>alert('OTP has expired. Please request a new one.'); window.location.href = 'registration.php';</script>";
        exit;
    }

    // Check if the entered code matches the session verification code
    if ($enteredCode == $_SESSION['verification_code']) {
        // Ensure that the security question was set during registration
        if (isset($_SESSION['security_question'])) {
            $_SESSION['security_question'] = $_SESSION['security_question'];  
        } else {
            echo "<script>alert('Security question is missing.'); window.location.href = 'registration.php';</script>";
            exit;
        }

        // Redirect to security question page if the verification code matches
        echo "<script>window.location.href = 'securityanswer.php';</script>";
    } else {
        echo "<script>alert('Incorrect verification code. Please try again.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Email Verification</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-in">
            <form id="verifyForm" method="POST" action="emailverify.php" >
                <h1>Email Verification</h1>
                <p>Please enter the verification code sent to your email.</p>
                <input type="text" name="verification_code" placeholder="Enter you 6 digit Code" id="verification_code" required>
                <div id="verificationError" style="color: red; display: none;"></div>
                <button type="submit" id = "Submit" >Verify Code</button>
            </form>
        </div>
    </div>

    

</body>
</html>
