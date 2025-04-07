<?php
session_start();
include('../includes/db_connect.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Access denied.");
}

$events = $conn->query("SELECT * FROM events ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Events</title>
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

        a.btn {
            padding: 6px 12px;
            background-color: #f39c12;
            color: #1e2a38;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 5px;
        }

        a.btn:hover {
            background-color: #e67e22;
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
    <h2>🎮 Manage Events</h2>

    <table>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Price (RM)</th>
            <th>Actions</th>
        </tr>
        <?php while ($event = $events->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($event['title']) ?></td>
            <td><?= date("F j, Y", strtotime($event['date'])) ?></td>
            <td><?= number_format($event['price'], 2) ?></td>
            <td>
                <a class="btn" href="edit_event.php?id=<?= $event['id'] ?>">Edit</a>
                <a class="btn" href="delete_event.php?id=<?= $event['id'] ?>" onclick="return confirm('Delete this event?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="back-link">
        <p><a href="dashboard.php">⬅ Back to Admin Dashboard</a></p>
    </div>
</body>
</html>

