<?php
require('fpdf/fpdf.php');

// Database connection
include 'db_connect.php';

// Fetch customer details
$customer_id = $_POST['customer'];
$customer_query = $conn->query("SELECT * FROM customer WHERE cid = $customer_id");
$customer = $customer_query->fetch_assoc();

// Fetch medicines
$selected_medicines = $_POST['medicines'];
$selected_quantities = $_POST['quantities'];
$selected_stock_ids = $_POST['stock_ids'];
$medicines = [];

foreach ($selected_medicines as $key => $med_id) {
    $quantity = $selected_quantities[$key];
    $stock_id = $selected_stock_ids[$key];
    $medicine_query = $conn->query("SELECT m.med_name, ms.rate FROM medicine m JOIN medicine_stock ms ON m.med_id = ms.med_id WHERE m.med_id = $med_id AND ms.stock_id = $stock_id");
    $medicine = $medicine_query->fetch_assoc();
    $medicine['quantity'] = $quantity;
    $medicine['total'] = $quantity * $medicine['rate'];
    $medicines[] = $medicine;
}

// Invoice details
$invoice_date = $_POST['invoice_date'];
$invoice_number = time();
$discount = $_POST['total_discount'];
$subtotal = array_sum(array_column($medicines, 'total'));
$net_total = $subtotal - $discount;

// Create PDF
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'INVOICE', 0, 1, 'C');
    }

    function Footer() {
        // No footer
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Logo
$pdf->Image('logo.png', 10, 10, 30);

// Invoice header
$pdf->SetXY(50, 10);
$pdf->Cell(0, 10, 'Invoice Number: #' . $invoice_number, 0, 1, 'R');
$pdf->SetXY(50, 20);
$pdf->Cell(0, 10, 'Date of Invoice: ' . $invoice_date, 0, 1, 'R');

// Customer details
$pdf->SetXY(10, 50);
$pdf->Cell(0, 10, 'INVOICE TO:', 0, 1);
$pdf->Cell(0, 10, $customer['c_name'], 0, 1);
$pdf->Cell(0, 10, $customer['c_address'], 0, 1);

// Table header
$pdf->SetXY(10, 80);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Medicine', 1);
$pdf->Cell(30, 10, 'Quantity', 1);
$pdf->Cell(40, 10, 'Unit Price', 1);
$pdf->Cell(40, 10, 'Total', 1);
$pdf->Ln();

// Table body
$pdf->SetFont('Arial', '', 12);
foreach ($medicines as $medicine) {
    $pdf->Cell(80, 10, $medicine['med_name'], 1);
    $pdf->Cell(30, 10, $medicine['quantity'], 1);
    $pdf->Cell(40, 10, number_format($medicine['rate'], 2), 1);
    $pdf->Cell(40, 10, number_format($medicine['total'], 2), 1);
    $pdf->Ln();
}

// Summary
$pdf->Cell(150, 10, 'Subtotal', 1);
$pdf->Cell(40, 10, number_format($subtotal, 2), 1);
$pdf->Ln();
$pdf->Cell(150, 10, 'Discount', 1);
$pdf->Cell(40, 10, number_format($discount, 2), 1);
$pdf->Ln();
$pdf->Cell(150, 10, 'Net Total', 1);
$pdf->Cell(40, 10, number_format($net_total, 2), 1);

// Output the PDF
$pdf->Output('I', 'invoice.pdf');
?>
