<?php
include('../includes/db_connect.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1a1a1a;
            color: #fff;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            background: #444;
            padding: 40px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            color: #03dac6;
            margin-bottom: 20px;
        }

        .message {
            font-size: 18px;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #03dac6;
            color: #000;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #01b5a2;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $event_id = $_POST['event_id'];
        $user_id = $_SESSION['user']['id'];

        if ($conn->query("INSERT INTO bookings (user_id, event_id) VALUES ($user_id, $event_id)")) {
            echo "<h2>Booking Confirmed!</h2>";
            echo "<div class='message'>You have successfully booked the event.</div>";
            echo "<a href='bookings.php' class='btn'>View My Bookings</a>";
        } else {
            echo "<h2>Booking Failed</h2>";
            echo "<div class='message'>There was a problem booking the event. Please try again.</div>";
        }
    }
    ?>
</div>

</body>
</html>
