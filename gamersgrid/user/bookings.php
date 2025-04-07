<?php
include('../includes/db_connect.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    die("Access denied.");
}

$user_id = $_SESSION['user']['id'];

// Handle cancel request
if (isset($_GET['cancel_id'])) {
    $cancel_id = intval($_GET['cancel_id']);
    $conn->query("UPDATE bookings SET status='Cancelled' WHERE id=$cancel_id AND user_id=$user_id AND status='Confirmed'");
}

// Fetch bookings
$result = $conn->query("SELECT b.id, b.status, e.title, e.date, e.price 
                        FROM bookings b 
                        JOIN events e ON b.event_id = e.id 
                        WHERE b.user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
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

        .bookings-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .booking-card {
            background-color: #2c3e50;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
            position: relative;
        }

        .booking-card h3 {
            margin: 0 0 10px 0;
            color: #4cd3c2;
        }

        .booking-card p {
            margin: 5px 0;
            line-height: 1.4;
            color: #ccc;
        }

        .status {
            font-weight: bold;
            color: #ffa94d;
        }

        .status.cancelled {
            color: #ff4d4d;
        }

        .btn-cancel {
            display: inline-block;
            padding: 6px 12px;
            margin-top: 10px;
            border: none;
            border-radius: 6px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
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
    <h2>📑 My Bookings</h2>

    <div class="bookings-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="booking-card">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p><strong>Date:</strong> <?= date("F j, Y", strtotime($row['date'])) ?></p>
                    <p><strong>Price:</strong> RM<?= number_format($row['price'], 2) ?></p>
                    <p class="status <?= strtolower($row['status']) ?>"><strong>Status:</strong> <?= $row['status'] ?></p>

                    <?php if ($row['status'] === 'Confirmed'): ?>
                        <a class="btn-cancel" href="?cancel_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; color: #aaa;">You have no bookings yet.</p>
        <?php endif; ?>
    </div>

    <div class="back-link">
        <p><a href="dashboard.php">⬅ Back to Dashboard</a></p>
    </div>
</body>
</html>
