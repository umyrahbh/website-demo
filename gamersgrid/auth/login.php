<?php
include('../includes/db_connect.php');
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;

        if ($user['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e2a38;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background-color: #fff;
            color: #333;
            border-radius: 10px;
            padding: 30px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .login-box p {
            text-align: center;
            font-size: 0.9em;
            color: #555;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            background-color: #4cd3c2;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-box .small-text {
            font-size: 0.8em;
            margin-top: 10px;
            text-align: center;
        }

        .login-box .small-text a {
            color: #1e90ff;
            text-decoration: none;
        }

        .login-box .small-text a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 0.9em;
            text-align: center;
            margin-bottom: 10px;
        }

        /* Align the checkbox and label on the same line */
    #show-password {
        display: inline;
        margin-right: 5px; /* Add space between checkbox and text */
    }

    label {
        display: inline;
        font-size: 0.9em; /* Optional: Adjust font size */
        color: #555; /* Optional: Style the label text */
    }
    
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <p>Welcome back! Please enter your credentials.</p>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" id="password" required>

    <!-- Show Password Toggle with label styled inline -->
    <label>
        <input type="checkbox" id="show-password"> Show Password
    </label>

    <button type="submit">Login</button>
</form>


        <script>
        document.getElementById('show-password').addEventListener('change', function() {
        var passwordField = document.querySelector('input[name="password"]');
        if (this.checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    });
</script>

        
        <p class="small-text">
            Don't have an account? <a href="register.php">Register here</a>
        </p>
    </div>
</body>
</html>
