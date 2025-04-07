<?php
include('../includes/db_connect.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Access denied.");
}

if (!isset($_GET['id'])) {
    die("No user ID specified.");
}

$user_id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

if (!$user) {
    die("User not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $conn->query("UPDATE users SET username = '$username', email = '$email', role = '$role' WHERE id = $user_id");
    header("Location: manage_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e2a38;
            color: #fff;
            margin: 0;
            padding: 40px;
        }

        h2 {
            text-align: center;
            color: #4cd3c2;
            margin-bottom: 30px;
        }

        .form-container {
            background-color: #2c3e50;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
            max-width: 500px;
            margin: 0 auto;
        }

        .form-container label {
            color: #ccc;
            display: block;
            margin-bottom: 8px;
        }

        .form-container input,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #34495e;
            background-color: #34495e;
            color: #fff;
        }

        .form-container button {
            background-color: #f39c12;
            color: #1e2a38;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #e67e22;
        }

        .back-link {
            text-align: center;
            margin-top: 30px;
        }

        .back-link a {
            color: #ccc;
            text-decoration: none;
        }

        .back-link a:hover {
            color: #4cd3c2;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Edit User: <?= htmlspecialchars($user['username']) ?></h2>

<div class="form-container">
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>

        <label for="role">Role:</label>
        <select name="role">
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select><br>

        <button type="submit">Save Changes</button>
    </form>
</div>

<div class="back-link">
    <p><a href="manage_users.php">⬅ Back to Manage Users</a></p>
</div>

</body>
</html>
