<?php
include('../includes/db_connect.php');
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = htmlspecialchars(trim($_POST['first_name']));
    $last = htmlspecialchars(trim($_POST['last_name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $errors[] = "Email already registered. Try logging in.";
    }
    $check->close();

    // If no errors, insert user into the database
    if (empty($errors)) {
        $username = $first . ' ' . $last;
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Database error: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GamersGrid | Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-box {
            background-color: #1e1e1e;
            color: #fff;
            border-radius: 12px;
            padding: 30px;
            width: 370px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.6);
        }

        .signup-box h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #03dac6;
        }

        .signup-box p {
            text-align: center;
            font-size: 0.9em;
            color: #ccc;
        }

        .signup-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background-color: #2a2a2a;
            border: 1px solid #444;
            border-radius: 6px;
            color: #fff;
        }

        .signup-box button {
            width: 100%;
            padding: 12px;
            background-color: #03dac6;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }

        .signup-box .small-text {
            font-size: 0.8em;
            margin-top: 10px;
            text-align: center;
            color: #aaa;
        }

        .signup-box .small-text a {
            color: #03dac6;
            text-decoration: none;
        }

        .signup-box .small-text a:hover {
            text-decoration: underline;
        }

        .error {
            background-color: #e74c3c;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 10px;
            font-size: 0.9em;
        }

        .password-strength {
            text-align: center;
            margin-top: 10px;
            color: #ccc;
            font-size: 0.9em;
        }

        .password-strength span {
            font-weight: bold;
        }

        .weak {
            color: red;
        }

        .moderate {
            color: orange;
        }

        .strong {
            color: green;
        }

        .popup-warning {
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.9em;
            margin-top: 10px;
            display: none; /* Initially hidden */
        }
    </style>
</head>
<body>
<div class="signup-box">
    <h2>📝 Sign Up</h2>
    <p>It's free and only takes a minute</p>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error) echo htmlspecialchars($error) . "<br>"; ?>
        </div>
    <?php endif; ?>

    <form method="POST" onsubmit="return validatePassword()">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Create Account</button>
    </form>

    <!-- Password Strength Meter -->
    <div class="password-strength">
        <span id="password-strength-text">Password Strength: </span><span id="password-strength-level">Weak</span>
    </div>

    <!-- Popup warning for password criteria -->
    <div id="popup-warning" class="popup-warning">
        Password must contain at least:
        <ul>
            <li>One uppercase letter</li>
            <li>One number</li>
            <li>One special character (e.g., @, #, $, %)</li>
            <li>At least 6 characters</li>
        </ul>
    </div>

    <p class="small-text">
        By clicking the Sign Up button, you agree to our
        <a href="#">Terms and Conditions</a> & <a href="#">Privacy Policy</a>.
    </p>
    <p class="small-text">Already have an account? <a href="login.php">Login here</a></p>
</div>

<script>
    // Function to evaluate password strength
    function evaluatePasswordStrength(password) {
        let strength = "Weak";
        let color = "red";
        const lengthCriteria = password.length >= 6;
        const uppercaseCriteria = /[A-Z]/.test(password);
        const numberCriteria = /\d/.test(password);
        const specialCharCriteria = /[\W_]/.test(password);

        // Check if all password criteria are met
        if (lengthCriteria && uppercaseCriteria && numberCriteria && specialCharCriteria) {
            strength = "Strong";
            color = "green";
        } else if (lengthCriteria && (uppercaseCriteria || numberCriteria || specialCharCriteria)) {
            strength = "Moderate";
            color = "orange";
        }

        // Update the password strength message
        document.getElementById("password-strength-text").innerText = "Password Strength: ";
        document.getElementById("password-strength-level").innerText = strength;
        document.getElementById("password-strength-level").style.color = color;
    }

    // Add event listener to the password field
    document.getElementById("password").addEventListener("input", function() {
        evaluatePasswordStrength(this.value);
    });

    // Validate password on form submit
    function validatePassword() {
        const password = document.getElementById("password").value;
        const lengthCriteria = password.length >= 6;
        const uppercaseCriteria = /[A-Z]/.test(password);
        const numberCriteria = /\d/.test(password);
        const specialCharCriteria = /[\W_]/.test(password);

        // Show warning if criteria are not met
        if (!(lengthCriteria && uppercaseCriteria && numberCriteria && specialCharCriteria)) {
            document.getElementById("popup-warning").style.display = "block";
            return false;  // Prevent form submission
        }

        return true;  // Allow form submission
    }
</script>

</body>
</html>
