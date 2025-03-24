<!DOCTYPE html>
<html>
<head>
    <title>Add Medicine</title>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/medicine.css">
</head>
<body>
    <?php
        // db_connect.php
       include "db_connect.php";

        // add_medicine.php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $med_name = $_POST['medicine-name'];
            $generic_name = $_POST['generic-name'];

            $sql = "INSERT INTO medicine (med_name, generic_name) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$med_name, $generic_name]);

            echo '<script>alert("Medicine added successfully.");</script>';
        }
    ?>

    <div class="medicine-depth-0">
        <div class="medicine-nav-depth-1">
            <div class="medicine-nav-depth-2">
                <div class="medicine-nav-depth-3-links">
                    <div class="medicine-nav-depth-4-logo">
                        <a href="dashboard.php"><img src="home.png" class="home-logo-img"></a>
                    </div>
                    <div class="medicine-nav-depth-4-links">
                        <ul class="medicine-nav-links">
                            <li><a href="add_medicine.php">Add Medicine</a></li>
                            <li><a href="view_medicine.php">View Medicine</a></li>
                            <li><a href="add_medicine_stock.php">Add Medicine Stock</a></li>
                            <li><a href="view_medicine_stock.php">View Medicine Stock</a></li>
                        </ul>
                    </div>
                </div>
                <div class="medicine-nav-depth-3-logout">
                    <a href="login.php">Log out</a>
                </div>
            </div>
        </div>

        <div class="medicine-container-depth-1">
            <div class="medicine-container-depth-2-head">
                <h1>Add a new medicine</h1>
            </div>
            <div class="medicine-container-depth-2-form">
                <form class="add-medicine-form" method="post">
                    <div class="form-field-add-medicine">
                        <label for="medicine-name">Medicine Name</label>
                        <input type="text" id="medicine-name" name="medicine-name" placeholder="Medicine name" required>
                    </div>
                    <div class="form-field-add-medicine">
                        <label for="generic-name">Generic Name</label>
                        <input type="text" id="generic-name" name="generic-name" placeholder="Generic name" required>
                    </div>
                    <div class="form-field-add-medicine">
                        <label for="med-company">Company Name</label>
                        <input type="text" id="med-company" name="med-company" placeholder="Company name" required>
                    </div>
                    <div class="form-field-add-medicine">
                        <label for="MRP">MRP</label>
                        <input type="text" id="MRP" name="MRP" placeholder="100" required>
                    </div>
                    <button class="button-add-medicine" type="submit">Add Medicine</button>
                </form>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
