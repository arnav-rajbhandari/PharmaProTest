<?php
include 'db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $batch_id = $_POST['batch-id'];
    $expiry_date = $_POST['expiry-date'];
    $quantity = $_POST['quantity'];
    $stock_id = $_POST['stock-id'];
    $rate = $_POST['rate'];
    $med_id = $_POST['med-id'];

    $sql = "INSERT INTO medicine_stock (batch_id, expiry_date, quantity, stock_id, rate, med_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$batch_id, $expiry_date, $quantity, $stock_id, $rate, $med_id]);

    echo '<script>alert("Stock added successfully.");</script>';
}

// Fetch medicines
$search = isset($_GET['search-medicine']) ? mysqli_real_escape_string($conn, $_GET['search-medicine']) : '';
$sql = "SELECT * FROM medicine";
if ($search != '') {
    $sql .= " WHERE med_name LIKE '%$search%' OR generic_name LIKE '%$search%' OR med_company LIKE '%$search%'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Medicine Stock</title>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/medicine-stock.css">
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
    <div class="medicine-stock-depth-0">
        <div class="medicine-stock-nav-depth-1">
            <div class="medicine-stock-nav-depth-2">
                <div class="medicine-stock-nav-depth-3-links">
                    <div class="medicine-stock-nav-depth-4-logo">
                        <a href="dashboard.php"><img src="home.png" class="home-logo-img"></a>
                    </div>
                    <div class="medicine-stock-nav-depth-4-links">
                        <ul class="medicine-stock-nav-links">
                            <li><a href="add_medicine.php">Add Medicine</a></li>
                            <li><a href="view_medicine.php">View Medicine</a></li>
                            <li><a href="add_medicine_stock.php">Add Medicine Stock</a></li>
                            <li><a href="view_medicine_stock.php">View Medicine Stock</a></li>
                        </ul>
                    </div>
                </div>
                <div class="medicine-stock-nav-depth-3-logout">
                    <a href="login.php">Log out</a>
                </div>
            </div>
        </div>

        <div class="medicine-stock-container-depth-1">
            <div class="medicine-stock-container-depth-2-head-med">
                <h1>View Medicine Stock</h1>
            </div>
            <div class="medicine-stock-container-depth-2-search-med">
                <form action="view_medicine_stock.php" method="GET">
                    <label for="search-medicine">Search:</label>
                    <input type="text" id="site-search" name="search-medicine" value="<?php echo isset($_GET['search-medicine']) ? htmlspecialchars($_GET['search-medicine']) : ''; ?>" />
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="medicine-stock-container-depth-2-content-med">
                
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Medicine Type</th>
                                    <th>Company Name</th>
                                    <th>MRP</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row["med_name"] . "</td>";
                                        echo "<td>" . $row["generic_name"] . "</td>";
                                        echo "<td>" . $row["med_company"] . "</td>";
                                        echo "<td>" . $row["MRP"] . "</td>";
                                        echo "<td><button class='button-select-medicine' type='button' onclick='selectMedicine(" . $row["med_id"] . ", \"" . $row["med_name"] . "\")'>Select</button></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No results found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                
            </div>

            <div class="medicine-stock-container-depth-2-form">
                <h2>Add Stock</h2>
                <form class="add-medicine-stock-form" method="post">
                    <input type="hidden" id="med-id" name="med-id">
                    <div class="form-field-add-medicine">
                        <label for="selected-medicine">Selected Medicine</label>
                        <input type="text" id="selected-medicine" name="selected-medicine" placeholder="Select a medicine from above" readonly required>
                    </div>
                    <div class="form-field-add-medicine">
                        <label for="batch-id">Batch ID</label>
                        <input type="text" id="batch-id" name="batch-id" placeholder="Enter Batch ID" required>
                    </div>
                    <div class="form-field-add-medicine">
                        <label for="expiry-date">Expiry Date</label>
                        <input type="date" id="expiry-date" name="expiry-date" placeholder="Enter Expiry Date" required>
                    </div>
                    <div class="form-field-add-medicine">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" placeholder="Enter Quantity" required>
                    </div>
                    <div class="form-field-add-medicine">
                        <label for="stock-id">Stock ID</label>
                        <input type="text" id="stock-id" name="stock-id" placeholder="Enter Stock ID" required>
                    </div>
                    <div class="form-field-add-medicine">
                        <label for="rate">Rate</label>
                        <input type="number" id="rate" name="rate" placeholder="Enter Rate" required>
                    </div>
                    <button class="button-add-medicine" type="submit">Add Stock</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function selectMedicine(medId, medName) {
            document.getElementById('med-id').value = medId;
            document.getElementById('selected-medicine').value = medName;
        }
    </script>
</body>
</html>
