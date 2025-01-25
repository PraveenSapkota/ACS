<?php
// Start session and regenerate ID to prevent session fixation
session_start();
session_regenerate_id(true);

// Including PHPMailer files for Email OTP
require 'PHPMailer-PHPMailer-2128d99/src/Exception.php';
require 'PHPMailer-PHPMailer-2128d99/src/PHPMailer.php';
require 'PHPMailer-PHPMailer-2128d99/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Including the AES encryption class
require 'encryption.php';

// Handling form submission through POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['honeypot'])) {    //HoneyPot field to catch bots.(If the hidden input area is filled,)
        exit("Registration failed: suspected bot.");    //(User is suspected as bot and will be thrown back to registration page)
    }

    // Google reCAPTCHA secret key(taken from V3 admin console)
    $recaptchaSecret = '6LfJjk8qAAAAACD4K1Smn-TNm4FqIyFbtyUQLdzp';

    // Verify reCAPTCHA response
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $recaptchaURL = 'https://www.google.com/recaptcha/api/siteverify';
    $data = ['secret' => $recaptchaSecret, 'response' => $recaptchaResponse];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $recaptchaURL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $recaptchaResult = curl_exec($ch);
    curl_close($ch);

    $resultJson = json_decode($recaptchaResult);                         // V3 captures the typing and cursor patterns
    if ($resultJson->success != true || $resultJson->score < 0.5) {     
        echo "<script>alert('reCAPTCHA verification failed. Please try again.');window.location.href = 'index.php';</script>";
        exit;
    }

    // Retrieving the input form data
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $security_question = $_POST['securityQuestion']; 
    $security_answer = $_POST['securityAnswer'];      

    // Basic validation
    if (!empty($email) && !empty($username) && !empty($password) && !empty($security_question) && !empty($security_answer)) {

       

        include 'config.php';  // Database connection

        // Checking if the username already exists in the database
        $stmt = $connect->prepare("SELECT * FROM register WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If Username already exists
            echo "<script>alert('This username is already taken. Please choose another one.');window.location.href = 'index.php';</script>";
            exit;
        }

        // Hashing the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Hashing the security answer as well.
        $hashedAnswer = password_hash($security_answer, PASSWORD_DEFAULT);

        // Generating a random 6 digit verification code
        $verificationCode = rand(100000, 999999);

        // Encrypting the email using AES
        $secret_key = 'ZygroG5ZGj5rANA8bn3PE5miz1/gec4haGGYZC4rESCd/hBAGMk2FeuOuswn+cg
        bYMg9cpP7w/uf0JBiXcisUUVuvKrVKmV5atpJB8HEdBuXwruHzpKVLvwr6qp3sRI2GdMTxBsu4vaqjh9
        lOtC0lL7iMqCk9ic/Gsuw07uVCi9yr5LNZ1MNrh/Tbwfx0uHb'; 
        $aes = new encryption($secret_key);
        $encryptedEmail = $aes->encrypt($email);

        // Finally, storing the verification code, encrypted email, and hashed password temporarily, in the session
        $_SESSION['verification_code'] = $verificationCode;
        $_SESSION['email'] = $encryptedEmail;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $hashedPassword;
        $_SESSION['security_question'] = $security_question;  
        $_SESSION['security_answer'] = $hashedAnswer;        
        $_SESSION['otp_expiration'] = time() + 100; // OTP valid for 100 sec to tighten security

        // Sending OTP via email
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'praveensapkota1@gmail.com';   // Created an email for this. 
            $mail->Password   = 'gakjatdevwwjpniq';             // Using app password for privacy.
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('praveensapkota1@gmail.com', 'EZ TECH');    // Giving random names and email domain
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = 'Your verification code is: ' . $verificationCode;  // Email sample to send.

            $mail->send();
            echo "<script>alert('A verification code has been sent to your email!'); window.location.href = 'emailverify.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error sending the email: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('Please fill out all fields.');</script>";
    }
}
?>