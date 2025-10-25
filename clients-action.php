<?php
include_once 'connect.php';
$conn = connectdb();

// Add client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_client'])) {
    $stmt = $conn->prepare("INSERT INTO clients (company_name, industry_type, contact_person, phone, email, address, country, status, added_by, created_at)
                            VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1, NOW())");
    $stmt->bind_param("sssssss", $_POST['company_name'], $_POST['industry_type'], $_POST['contact_person'], $_POST['phone'], $_POST['email'], $_POST['address'], $_POST['country']);
    $stmt->execute();
    $stmt->close();
    log_activity($conn, $_SESSION['user_id'], 'clients', 'Added new client: ' . $_POST['company_name']);
    header("Location: clients.php?msg=added");
    exit;
}

// Update client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $stmt = $conn->prepare("UPDATE clients SET company_name=?, industry_type=?, contact_person=?, phone=?, email=?, address=?, country=? WHERE client_id=?");
    $stmt->bind_param("sssssssi", $_POST['company_name'], $_POST['industry_type'], $_POST['contact_person'], $_POST['phone'], $_POST['email'], $_POST['address'], $_POST['country'], $_POST['client_id']);
    $stmt->execute();
    $stmt->close();
    echo "success";
    exit;
}

// Delete client
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM clients WHERE client_id = $id");
    header("Location: clients.php?msg=deleted");
    exit;
}

// Generate PDF
if (isset($_GET['action']) && $_GET['action'] === 'generate_pdf') {
    require('fpdf/fpdf.php');
    $result = $conn->query("SELECT * FROM clients ORDER BY client_id DESC");

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Clients Report', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, 'ID', 1);
    $pdf->Cell(40, 10, 'Company', 1);
    $pdf->Cell(30, 10, 'Industry', 1);
    $pdf->Cell(30, 10, 'Contact', 1);
    $pdf->Cell(40, 10, 'Email', 1);
    $pdf->Cell(40, 10, 'Country', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 9);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $row['client_id'], 1);
        $pdf->Cell(40, 10, substr($row['company_name'], 0, 20), 1);
        $pdf->Cell(30, 10, substr($row['industry_type'], 0, 15), 1);
        $pdf->Cell(30, 10, substr($row['contact_person'], 0, 15), 1);
        $pdf->Cell(40, 10, substr($row['email'], 0, 20), 1);
        $pdf->Cell(40, 10, substr($row['country'], 0, 15), 1);
        $pdf->Ln();
    }

    if (!file_exists('reports')) mkdir('reports', 0777, true);
    $pdf->Output('F', 'reports/clients_report.pdf');
    header("Location: clients.php");
    exit;
}
?>
