<?php
include 'header.php';
include_once 'connect.php';
require('fpdf/fpdf.php'); // Make sure fpdf.php is placed inside `fpdf/` folder

$conn = connectdb();

if ($_GET['action'] === 'generate_pdf') {
  $result = $conn->query("SELECT * FROM users WHERE status = 1 ORDER BY user_id DESC");

  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial','B',16);
  $pdf->Cell(190,10,'Users Report',0,1,'C');
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(10,10,'ID',1);
  $pdf->Cell(40,10,'Name',1);
  $pdf->Cell(60,10,'Email',1);
  $pdf->Cell(30,10,'Role',1);
  $pdf->Cell(50,10,'Created At',1);
  $pdf->Ln();

  $pdf->SetFont('Arial','',11);
  while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10,10,$row['user_id'],1);
    $pdf->Cell(40,10,$row['name'],1);
    $pdf->Cell(60,10,$row['email'],1);
    $pdf->Cell(30,10,$row['role'],1);
    $pdf->Cell(50,10,$row['created_at'],1);
    $pdf->Ln();
  }

  if (!file_exists('reports')) {
    mkdir('reports', 0777, true);
  }

  $pdf->Output('F', 'reports/users_report.pdf');
  exit;
}

if ($_GET['action'] === 'fetch') {
  $result = $conn->query("SELECT * FROM users WHERE status = 1 ORDER BY user_id DESC");
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['user_id']}</td>
            <td class='editable'>{$row['name']}</td>
            <td class='editable'>{$row['email']}</td>
            <td class='editable'>{$row['role']}</td>
            <td>{$row['created_at']}</td>
            <td class='action-icons'>
              <i class='fas fa-pen' onclick=\"enableEdit($(this).closest('tr').find('td.editable:first'), {$row['user_id']}, 'name', '{$row['name']}')\"></i>
              <i class='fas fa-trash text-danger' onclick='deleteUser({$row['user_id']})'></i>
            </td>
          </tr>";
  }
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['action'] === 'update') {
    $userId = intval($_POST['user_id']);
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE user_id=?");
    $stmt->bind_param("sssi", $_POST['name'], $_POST['email'], $_POST['role'], $userId);
    $stmt->execute();
    $stmt->close();
    exit;
  }

  if ($_POST['action'] === 'delete') {
    $userId = intval($_POST['user_id']);
    $stmt = $conn->prepare("UPDATE users SET status=0 WHERE user_id=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
    exit;
  }
}

if ($_POST['action'] == 'add') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $created_at = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at, status) VALUES (?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sssss", $name, $email, $password, $role, $created_at);
    $stmt->execute();
    echo "success";
    exit;
}
