<?php
include 'db_connect.php';

// Fetch customers
$customers_result = $conn->query("SELECT cid, c_name FROM customer");

// Fetch medicines
$medicines_result = $conn->query("
    SELECT m.med_id, m.med_name, ms.stock_id, ms.expiry_date, ms.quantity, ms.rate, m.MRP 
    FROM medicine m
    JOIN medicine_stock ms ON m.med_id = ms.med_id
    WHERE ms.quantity > 0
");

$customers = $customers_result->fetch_all(MYSQLI_ASSOC);
$medicines = $medicines_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Invoice</title>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/pharma.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <script type="text/javascript" src="script.js"></script>

    <div class="pharma-depth-0">
        <div class="pharma-nav-depth-1">
            <div class="pharma-nav-depth-2">
                <div class="pharma-nav-depth-3-links">
                    <div class="pharma-nav-depth-4-logo">
                        <a href="dashboard.php"><img src="home.png" class="home-logo-img"></a>
                    </div>
                    <div class="pharma-nav-depth-4-links">
                        <ul class="pharma-nav-links">
                            <li><a href="#">Generate Invoice</a></li>
                            <li><a href="#">View Invoices</a></li>
                            <li><a href="#">Return</a></li>
                        </ul>
                    </div>
                </div>
                <div class="pharma-nav-depth-3-logout">
                    <a href="login.php">Log out</a>
                </div>
            </div>
        </div>

        <div class="pharma-container-depth-1">
            <h1>Create Invoice</h1>
            <form id="invoice-form" method="POST" action="generate_invoice.php">
                <label for="customer">Customer:</label>
                <select name="customer" id="customer" required>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?php echo $customer['cid']; ?>"><?php echo $customer['c_name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="invoice_date">Invoice Date:</label>
                <input type="date" name="invoice_date" id="invoice_date" value="<?php echo date('Y-m-d'); ?>" required>

                <label for="medicine">Select Medicine:</label>
                <select id="medicine-dropdown" required>
                    <option value="">Select a Medicine</option>
                    <?php 
                    foreach ($medicines as $medicine): ?>
                        <option value="<?php echo $medicine['med_id']; ?>"><?php echo $medicine['med_name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <h2>Medicines</h2>
                <table id="medicine-table">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Stock ID</th>
                            <th>Expiry Date</th>
                            <th>Available Quantity</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>MRP</th>
                            <th>Add</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <h2>Invoice Summary</h2>
                <table id="invoice-summary">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div class="invoice-summary-container">
                    <div class="invoice-actions">    
                        <label for="total_discount">Discount:</label>
                        <input type="number" name="total_discount" id="total_discount" value="0">

                        <p>Subtotal: $<span id="subtotal">0.00</span></p>
                        <p>Net Total: $<span id="net_total">0.00</span></p>

                        <input type="hidden" name="total_amount" id="total_amount" value="0.00">
                        <input type="hidden" name="voucher_no" value="<?php echo time(); ?>">

                        <button type="submit">Generate Invoice</button>
                    </div>    
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const medicines = <?php echo json_encode($medicines); ?>;

            $('#medicine-dropdown').change(function() {
                const selectedMedId = $(this).val();
                const filteredMedicines = medicines.filter(medicine => medicine.med_id == selectedMedId);
                $('#medicine-table tbody').empty();

                filteredMedicines.forEach(medicine => {
                    $('#medicine-table tbody').append(`
                        <tr data-med-id="${medicine.med_id}">
                            <td>${medicine.med_name}</td>
                            <td>${medicine.stock_id}</td>
                            <td>${medicine.expiry_date}</td>
                            <td class="available-quantity">${medicine.quantity}</td>
                            <td><input type="number" name="quantity[]" min="1" max="${medicine.quantity}" value="1" class="quantity-input"></td>
                            <td>${medicine.rate}</td>
                            <td>${medicine.MRP}</td>
                            <td>
                                <button type="button" class="add-btn">Add</button>
                                <input type="hidden" name="selected_medicines[]" value="${medicine.med_id}" data-stock-id="${medicine.stock_id}" data-rate="${medicine.rate}">
                            </td>
                        </tr>
                    `);
                });

                // Attach change event to quantity inputs to update available quantity
                $('.quantity-input').on('input', function() {
                    const row = $(this).closest('tr');
                    const maxQuantity = parseInt($(this).attr('max'));
                    const inputQuantity = parseInt($(this).val());
                    if (inputQuantity > maxQuantity) {
                        $(this).val(maxQuantity);
                    }
                    const remainingQuantity = maxQuantity - inputQuantity;
                    row.find('.available-quantity').text(remainingQuantity);
                });
            });

            // Handle click on "Add" button
            $('#medicine-table').on('click', '.add-btn', function() {
                const row = $(this).closest('tr');
                const medicineId = row.find('input[name="selected_medicines[]"]').val();
                const quantityInput = row.find('input[name="quantity[]"]');
                const quantity = parseFloat(quantityInput.val());
                const rate = parseFloat(row.find('input[name="selected_medicines[]"]').data('rate'));
                const medicineName = row.find('td').eq(0).text();
                const totalPrice = quantity * rate;

                if (!isNaN(quantity) && !isNaN(rate)) {
                    // Check if the medicine is already added
                    const existingRow = $('#invoice-summary tbody tr[data-medicine-id="' + medicineId + '"]');
                    if (existingRow.length > 0) {
                        // Update existing row
                        const existingQuantity = parseFloat(existingRow.find('.quantity').text()) + quantity;
                        const newTotalPrice = existingQuantity * rate;
                        existingRow.find('.quantity').text(existingQuantity);
                        existingRow.find('.total-price').text(newTotalPrice.toFixed(2));
                    } else {
                        // Add new row
                        $('#invoice-summary tbody').append(`
                            <tr data-medicine-id="${medicineId}">
                                <td>${medicineName}</td>
                                <td class="quantity">${quantity}</td>
                                <td>$${rate.toFixed(2)}</td>
                                <td class="total-price">$${totalPrice.toFixed(2)}</td>
                            </tr>
                        `);
                    }

                    // Add medicine ID, stock ID, and quantity to hidden inputs
                    $('#invoice-form').append(`
                        <input type="hidden" name="medicines[]" value="${medicineId}">
                        <input type="hidden" name="stock_ids[]" value="${row.find('input[name="selected_medicines[]"]').data('stock-id')}">
                        <input type="hidden" name="quantities[]" value="${quantity}">
                    `);

                    updateSummary();

                    // Update available quantity in the medicine table
                    const maxQuantity = parseInt(quantityInput.attr('max'));
                    const remainingQuantity = maxQuantity - quantity;
                    row.find('.available-quantity').text(remainingQuantity);
                    quantityInput.attr('max', remainingQuantity);
                }
            });

            // Function to update invoice summary
            const updateSummary = () => {
                let subtotal = 0;
                $('#invoice-summary tbody tr').each(function() {
                    const totalPrice = parseFloat($(this).find('.total-price').text().replace('$', ''));
                    if (!isNaN(totalPrice)) {
                        subtotal += totalPrice;
                    }
                });

                $('#subtotal').text(subtotal.toFixed(2));
                const discount = parseFloat($('#total_discount').val()) || 0;
                const netTotal = subtotal - discount;
                $('#net_total').text(netTotal.toFixed(2));
                $('#total_amount').val(netTotal.toFixed(2));
            };

            // Update summary on discount change
            $('#total_discount').change(updateSummary);
        });
    </script>
</body>
</html>
