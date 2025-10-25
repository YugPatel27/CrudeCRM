<?php
session_start();
include 'connect.php';
$conn = connectdb();

$id = $_POST['user_id'];
$name = $_POST['name'];
$email = $_POST['email'];

$stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE user_id=?");
$stmt->bind_param("ssi", $name, $email, $id);
echo $stmt->execute() ? "success" : "error";
?>
