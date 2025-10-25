<?php
include_once 'connect.php';
$conn = connectdb();
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $id = intval($data['id']);
    unset($data['id']);

    $set = "";
    $params = [];
    $types = "";

    foreach ($data as $key => $val) {
        $set .= "$key = ?, ";
        $params[] = $val;
        $types .= is_numeric($val) ? 'd' : 's';
    }

    $set = rtrim($set, ", ");
    $params[] = $id;
    $types .= "i";

    $stmt = $conn->prepare("UPDATE invoices SET $set WHERE invoice_id = ?");
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    echo "Updated";
}
?>
