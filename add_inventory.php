<?php
include_once 'connect.php';
$conn = connectdb();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO inventory (product_id, location, quantity, last_updated) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ssi", $_POST['product_id'], $_POST['location'], $_POST['quantity']);
    $stmt->execute();
    $stmt->close();
    header("Location: inventory.php?msg=added");
    exit;
}
?>
