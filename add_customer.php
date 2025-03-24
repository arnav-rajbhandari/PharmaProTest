<html>
  <head>
    <title>Dashboard Try</title>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/customer.css">
  </head>
  <body>
            <?php
                // db_connect.php
                $host = 'localhost';
                $dbname = 'pharma_pro';
                $user = 'root';
                $password = '';

                try {
                    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    echo '<script>alert("Connection failed: ' . $e->getMessage() . '");</script>';
                }

                // add_customer.php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $c_name = $_POST['customer-name'];
                    $c_contact = $_POST['phone-number'];
                    $c_address = $_POST['address'];
                    $doctor_name = $_POST['doctor-name'];

                    $sql = "INSERT INTO customer (c_name, c_contact, c_address, doctor_name) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$c_name, $c_contact, $c_address, $doctor_name]);

                    echo '<script>alert("Customer added successfully.");</script>';
                }
            ?>



     <script src="script.js"></script>

    <div class="customer-depth-0">
      <div class="customer-nav-depth-1">
        <div class="customer-nav-depth-2">
          <div class="customer-nav-depth-3-links">
            <div class="customer-nav-depth-4-logo">
              <a href="dashboard.php"><img src="home.png" class="home-logo-img"></a>
            </div>
            <div class="customer-nav-depth-4-links">
              <ul class="customer-nav-links">
                        <li><a href="add_customer.php ?>">Add Customer</a></li>
                        <li><a href="view_customer.php">View Customer</a></li>
                        <li><a href="edit_customer.php">Edit Customer</a></li>
                    </ul>
            </div>
          </div>
          <div class="customer-nav-depth-3-logout">
            <a href="login.php">Log out</a>
          </div>
        </div>
      </div>

            <div class="customer-container-depth-1">
            <div class="customer-container-depth-2-head">
            <h1>Add a new customer</h1>
            </div>
            <div class="customer-container-depth-2-form">
              <form class="add-customer-form" method="post">
                <div class="form-field-add-customer">
                  <label for="customer-name">Customer Name</label>
                  <input type="text" id="customer-name" name="customer-name" placeholder="Your name">
                </div>
                <div class="form-field-add-customer">
                  <label for="phone-number">Phone Number</label>
                  <input type="text" id="phone-number" name="phone-number" placeholder="9XXXXXXXXX">
                </div>
                <div class="form-field-add-customer">
                  <label for="email-address">Email Address</label>
                  <input type="email" id="email-address" name="email-address" placeholder="example@gmail.com">
                </div>
                <div class="form-field-add-customer">
                  <label for="address">Address</label>
                  <input type="text" id="address" name="address" placeholder="Hattiban-21, Lalitpur">
                </div>
                <div class="form-field-add-customer">
                  <label for="doctor-name">Doctor's Name</label>
                  <input type="text" id="doctor-name" name="doctor-name" placeholder ="Dr. Jane Smith">
                </div>
                <button class="button-add-customer" type="submit">Add Customer</button>
              </form>
            </div>
          </div>
    </div>
  </body>
</html>


