<?php
include('../includes/db_connect.php');
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    die("Access denied.");
}
$events = $conn->query("SELECT * FROM events");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e2a38;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #4cd3c2;
            margin-bottom: 30px;
        }

        .events-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .event-card {
            background-color: #2c3e50;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
        }

        .event-card h3 {
            margin-top: 0;
            color: #4cd3c2;
        }

        .event-card p {
            margin: 8px 0;
            line-height: 1.4;
        }

        .event-card form {
            margin-top: 15px;
        }

        .event-card button {
            background-color: #4cd3c2;
            color: #1e2a38;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .event-card button:hover {
            background-color: #38b9a7;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 40px;
            color: #ccc;
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
    <h2>🎮 Available Events</h2>

    <div class="events-container">
        <?php while ($row = $events->fetch_assoc()): ?>
            <div class="event-card">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p><strong>Date:</strong> <?= $row['date'] ?></p>
                <p><strong>Price:</strong> RM<?= number_format($row['price'], 2) ?></p>
                <form method="POST" action="book_event.php">
                    <input type="hidden" name="event_id" value="<?= $row['id'] ?>">
                    <button type="submit">Register & Pay</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="back-link">
        <p><a href="dashboard.php">⬅ Back to Dashboard</a></p>
    </div>
</body>
</html>
