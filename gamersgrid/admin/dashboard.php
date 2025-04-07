<?php
session_start();
include('../includes/db_connect.php'); // Make sure your DB connection is correct

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Access denied.");
}

$username = $_SESSION['user']['username'];

// Fetch total counts
$total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$total_events = $conn->query("SELECT COUNT(*) AS count FROM events")->fetch_assoc()['count'];
$total_registrations = $conn->query("SELECT COUNT(*) AS count FROM bookings")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e2a38;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #2c3e50;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #f39c12;
            margin-bottom: 20px;
        }

        p.welcome {
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
            color: #ccc;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            text-align: center;
        }

        .stat-box {
            background-color: #34495e;
            padding: 20px;
            border-radius: 12px;
            width: 30%;
        }

        .stat-box h3 {
            margin: 0;
            font-size: 22px;
            color: #4cd3c2;
        }

        .stat-box p {
            font-size: 16px;
            margin-top: 8px;
            color: #ddd;
        }

        .actions a {
            display: block;
            background-color: #f39c12;
            color: #1e2a38;
            text-decoration: none;
            padding: 14px;
            margin: 10px 0;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .actions a:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Admin Panel</h2>
        <p class="welcome">Welcome, <?= htmlspecialchars($username) ?> 👨‍💼</p>

        <div class="stats">
            <div class="stat-box">
                <h3><?= $total_users ?></h3>
                <p>Total Users</p>
            </div>
            <div class="stat-box">
                <h3><?= $total_events ?></h3>
                <p>Total Events</p>
            </div>
            <div class="stat-box">
                <h3><?= $total_registrations ?></h3>
                <p>Total Registrations</p>
            </div>
        </div>

        <div class="actions">
            <!-- Link to Create Event remains intact -->
            <a href="create_event.php">➕ Create Event</a>
            <a href="manage_users.php">👥 Manage Users</a>
            <a href="manage_events.php">🎮 Manage Events</a>
            <a href="manage_registrations.php">📋 Manage Registrations</a>
            <a href="../auth/logout.php">🚪 Logout</a>
        </div>
    </div>
</body>
</html>
