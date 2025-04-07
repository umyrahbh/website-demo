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

    // Delete the user from the database
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        header("Location: manage_users.php"); // Redirect to the manage users page
    } else {
        echo "Error deleting user.";
    }
}
?>
