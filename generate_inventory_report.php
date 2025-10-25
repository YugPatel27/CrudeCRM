<?php
require('fpdf/fpdf.php');
include_once 'connect.php';
$conn = connectdb();

// PDF Setup
$pdf = new FPDF(); $pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0, 10, 'Inventory Report', 0,1,'C');
$pdf->Ln(8);

// Table Header
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(192,57,43);
$pdf->SetTextColor(255);
$pdf->Cell(15,10,'ID',1,0,'C',true);
$pdf->Cell(30,10,'Product ID',1,0,'C',true);
$pdf->Cell(70,10,'Location',1,0,'C',true);
$pdf->Cell(25,10,'Qty',1,0,'C',true);
$pdf->Cell(50,10,'Last Updated',1,1,'C',true);

// Data Rows
$pdf->SetFont('Arial','',12); $pdf->SetTextColor(0);
$res = $conn->query("SELECT * FROM inventory ORDER BY inventory_id DESC");
while ($r = $res->fetch_assoc()) {
  $pdf->Cell(15,10,$r['inventory_id'],1);
  $pdf->Cell(30,10,$r['product_id'],1);
  $pdf->Cell(70,10,$r['location'],1);
  $pdf->Cell(25,10,number_format($r['quantity'],2),1);
  $pdf->Cell(50,10,$r['last_updated'],1,1);
}

// Save and redirect
$dir = 'reports/'; if (!is_dir($dir)) mkdir($dir,0777,true);
$file = $dir.'inventory_report_'.date('Ymd_His').'.pdf';
$pdf->Output('F', $file);
header("Location: inventory.php?success=1&file=".urlencode($file));
exit;
?>
