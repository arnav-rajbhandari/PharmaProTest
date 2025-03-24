<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $customer_id = $_POST['customer'];
    $invoice_date = $_POST['invoice_date'];
    $discount = $_POST['total_discount'];
    $total_amount = $_POST['total_amount'];
    $voucher_no = $_POST['voucher_no'];

    $medicines = $_POST['medicines'];
    $stock_ids = $_POST['stock_ids'];
    $quantities = $_POST['quantities'];

    // Insert invoice into the database
    $stmt = $conn->prepare("INSERT INTO invoice (customer_id, invoice_date, discount, total_amount, voucher_no) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('issds', $customer_id, $invoice_date, $discount, $total_amount, $voucher_no);
    $stmt->execute();
    $invoice_id = $stmt->insert_id;
    $stmt->close();

    // Insert invoice details and update stock
    $stmt = $conn->prepare("INSERT INTO invoice_details (invoice_id, med_id, stock_id, quantity, rate) VALUES (?, ?, ?, ?, ?)");
    $update_stock_stmt = $conn->prepare("UPDATE medicine_stock SET quantity = quantity - ? WHERE stock_id = ?");

    for ($i = 0; $i < count($medicines); $i++) {
        $med_id = $medicines[$i];
        $stock_id = $stock_ids[$i];
        $quantity = $quantities[$i];

        // Get rate from medicine_stock table
        $rate_result = $conn->query("SELECT rate FROM medicine_stock WHERE stock_id = '$stock_id'");
        $rate = $rate_result->fetch_assoc()['rate'];

        // Insert invoice details
        $stmt->bind_param('iiidi', $invoice_id, $med_id, $stock_id, $quantity, $rate);
        $stmt->execute();

        // Update stock quantity
        $update_stock_stmt->bind_param('ii', $quantity, $stock_id);
        $update_stock_stmt->execute();
    }

    $stmt->close();
    $update_stock_stmt->close();
    $conn->close();

    echo "Invoice generated successfully.";
}
?>
