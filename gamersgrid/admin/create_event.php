<?php
include('../includes/db_connect.php');
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Access denied.");
}

$success = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $date = $_POST['date'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO events (title, description, date, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $title, $desc, $date, $price);
    if ($stmt->execute()) {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e2a38;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #2c3e50;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
            width: 400px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #4cd3c2;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            background-color: #ecf0f1;
            color: #2c3e50;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4cd3c2;
            color: #1e2a38;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #38b9a7;
        }

        .message {
            text-align: center;
            color: #2ecc71;
            margin-top: 15px;
            font-weight: bold;
        }

        .back-link {
            margin-top: 20px;
            text-align: center;
        }

        .back-link a {
            color: #ccc;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
            color: #4cd3c2;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>➕ Create New Event</h2>

        <form method="POST">
            <input name="title" placeholder="Event Title" required>
            <textarea name="description" placeholder="Event Description" rows="4" required></textarea>
            <input name="date" type="date" required>
            <input name="price" type="number" step="0.01" placeholder="Ticket Price (RM)" required>
            <button type="submit">Create Event</button>
        </form>

        <?php if ($success): ?>
            <div class="message">🎉 Event Created Successfully!</div>
        <?php endif; ?>

        <div class="back-link">
            <p><a href="dashboard.php">⬅ Back to Admin Dashboard</a></p>
        </div>
    </div>
</body>
</html>
