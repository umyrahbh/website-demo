<?php
$conn = new mysqli("localhost", "root", "", "gamersgrid");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>