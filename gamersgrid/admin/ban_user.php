<?php
include('../includes/db_connect.php');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Access denied.");
}

// Check if the user ID is provided
if (isset($_GET['id'])) {
    $user_id = (int) $_GET['id'];

    // Update the user's status to 'banned'
    $stmt = $conn->prepare("UPDATE users SET status = 'banned' WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        header("Location: manage_users.php"); // Redirect to the manage users page
    } else {
        echo "Error banning user.";
    }
}
?>
