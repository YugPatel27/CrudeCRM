<?php
// Create database connection
$conn = new mysqli("localhost", "root", "", "crmcruddb");

// Check for errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
