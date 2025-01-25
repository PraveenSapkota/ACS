<?php
session_start();

// Including the database connection file
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the answer entered by the user
    $userAnswer = trim($_POST['security_answer']);

    // Check if the answer matches the one stored in the session(stored in registration.php)
    if (password_verify($userAnswer, $_SESSION['security_answer'])) {
        //If The answer is correct. Insert the user data into the database.
        $encryptedEmail = $_SESSION['email']; // Encrypted email from the session
        $username = $_SESSION['username'];
        $hashedPassword = $_SESSION['password']; // BCrypt hashed password
        $securityQuestion = $_SESSION['security_question']; // The selected security question
        $hashedAnswer = password_hash($userAnswer, PASSWORD_BCRYPT); // Hash the security answer for storage

        // Prepare and execute the insert statement
        $stmt = $connect->prepare("INSERT INTO register (email, username, password, security_question, security_answer_hash) VALUES (?, ?, ?, ?, ?)");

        if ($stmt === false) {
            // If the prepare fails, display the error
            echo "Error preparing statement: " . $connect->error;
        } else {
            // Bind the parameters and execute
            $stmt->bind_param("sssss", $encryptedEmail, $username, $hashedPassword, $securityQuestion, $hashedAnswer);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href = 'welcome.html';</script>";
            } else {
                echo "<script>alert('Error: Could not save user.');</script>";
            }
        }

        // Clear session data after successful registration
        session_unset();
        session_destroy();
    } else {
        // Provide a generic error message for security
        echo "<script>alert('Incorrect answer. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Security Question</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-in">
            <form id="securityQuestionForm" method="POST" action="securityanswer.php">
                <h1>Security Question</h1>
                <p>Please answer the security question you selected during registration.</p>
                
                <!-- Display the security question stored in the session -->
                <label for="security_question"><?php echo htmlspecialchars($_SESSION['security_question']); ?></label>
                <input type="text" name="security_answer" placeholder="Answer" id="security_answer" required>
                <div id="answerError" style="color: red; display: none;"></div>
                <button type="submit" id = "answer">Submit Answer</button>
            </form>
        </div>
    </div>

    

</body>
</html>
