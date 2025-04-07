<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    die("Access denied.");
}
$username = $_SESSION['user']['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e2a38;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .dashboard-container {
            background-color: #2c3e50;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        .dashboard-container h2 {
            margin-bottom: 20px;
            font-size: 26px;
            color: #4cd3c2;
        }

        .dashboard-container p {
            margin-bottom: 30px;
            font-size: 18px;
        }

        .dashboard-container a {
            display: block;
            background-color: #4cd3c2;
            color: #1e2a38;
            text-decoration: none;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .dashboard-container a:hover {
            background-color: #38b9a7;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>
        <p>Your eSports journey starts here 🎮</p>

        <a href="events.php">🎟 Browse Events</a>
        <a href="bookings.php">📑 My Bookings</a>
        <a href="../auth/logout.php">🚪 Logout</a>
    </div>
</body>
</html>
