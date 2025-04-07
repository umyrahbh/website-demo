<?php
include('../includes/db_connect.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Access denied.");
}

$users = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
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

        .user-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 10px;
            max-width: 1000px;
            margin: 0 auto;
            padding: 10px;
        }

        .user-card {
            background-color: #2c3e50;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
            height: 200px; /* Ensure consistent box height */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Ensure buttons are at the bottom */
        }

        .user-card h3 {
            margin: 0 0 10px;
            color: #f1c40f;
        }

        .user-card p {
            margin: 5px 0;
            color: #ccc;
        }

        .user-role {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: bold;
        }

        .role-user {
            background-color: #3498db;
            color: #fff;
        }

        .role-admin {
            background-color: #e74c3c;
            color: #fff;
        }

        .button-container {
            text-align: center;
            margin-top: 15px;
        }

        .button-container a {
            background-color: #f39c12;
            color: #1e2a38;
            text-decoration: none;
            padding: 10px;
            margin: 5px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .button-container a:hover {
            background-color: #e67e22;
        }

        .back-link {
            margin-top: 30px;
            text-align: center;
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

<h2>👥 Manage Users</h2>

<div class="user-container">
    <?php while ($u = $users->fetch_assoc()): ?>
        <div class="user-card">
            <h3><?= htmlspecialchars($u['username']) ?></h3>
            <p>Email: <?= htmlspecialchars($u['email']) ?></p>
            <p>
                Role: 
                <span class="user-role <?= $u['role'] === 'admin' ? 'role-admin' : 'role-user' ?>">
                    <?= ucfirst($u['role']) ?>
                </span>
            </p>

            <div class="button-container">
                <a href="edit_user.php?id=<?= $u['id'] ?>">✏️ Edit</a>
                <a href="delete_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">🗑️ Delete</a>
                <a href="ban_user.php?id=<?= $u['id'] ?>">🚫 Ban</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<div class="back-link">
    <p><a href="dashboard.php">⬅ Back to Admin Dashboard</a></p>
</div>

</body>
</html>
