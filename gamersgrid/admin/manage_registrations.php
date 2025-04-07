<?php
session_start();
include('../includes/db_connect.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Access denied.");
}

$registrations = $conn->query("SELECT b.id, u.username, e.title, e.date, b.status
                               FROM bookings b
                               JOIN users u ON b.user_id = u.id
                               JOIN events e ON b.event_id = e.id
                               ORDER BY e.date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Registrations</title>
    <style>
        body {
            background-color: #1e2a38;
            color: #fff;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #4cd3c2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #2c3e50;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #444;
        }

        th {
            background-color: #34495e;
        }

        .status {
            font-weight: bold;
        }

        .status.Confirmed {
            color: #4cd3c2;
        }

        .status.Cancelled {
            color: #e74c3c;
        }

        .back-link {
            margin-top: 30px;
            text-align: center;
        }

        .back-link a {
            color: #4cd3c2;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>📋 Manage Registrations</h2>

    <table>
        <tr>
            <th>Username</th>
            <th>Event</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $registrations->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= date("F j, Y", strtotime($row['date'])) ?></td>
            <td class="status <?= $row['status'] ?>"><?= $row['status'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="back-link">
        <p><a href="dashboard.php">⬅ Back to Admin Dashboard</a></p>
    </div>
</body>
</html>
