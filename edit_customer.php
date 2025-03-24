<!DOCTYPE html>
<html>
<head>
  <title>Edit Customer</title>
  <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="css/customer.css">
</head>
<body>
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
              <li><a href="add_customer.php">Add Customer</a></li>
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
        <h1>Edit Customer Data</h1>
      </div>
      <div class="customer-container-depth-2-form">
        <?php
        include 'db_connect.php';

        if (isset($_GET['cid'])) {
          $cid = mysqli_real_escape_string($conn, $_GET['cid']);
          $sql = "SELECT * FROM customer WHERE cid = $cid";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
          } else {
            echo "No record found.";
            exit();
          }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
          $cid = $_POST['cid'];
          $c_name = $_POST['customer-name'];
          $c_contact = $_POST['phone-number'];
          $c_address = $_POST['address'];
          $doctor_name = $_POST['doctor-name'];

          $sql = "UPDATE customer SET c_name='$c_name', c_contact='$c_contact', c_address='$c_address', doctor_name='$doctor_name' WHERE cid=$cid";

          if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Record edited successfully.");</script>';
            header("Location: view_customer.php");
            exit;
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
          $cid = $_POST['cid'];
          $sql = "DELETE FROM customer WHERE cid=$cid";

          if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Record deleted successfully.");</script>';
            header("Location: view_customer.php");
            exit;
          } else {
            echo "Error deleting record: " . mysqli_error($conn);
          }
        }

        mysqli_close($conn);
        ?>
        <form class="add-customer-form" method="post" action="edit_customer.php?cid=<?php echo $row['cid']; ?>">
          <input type="hidden" name="cid" value="<?php echo $row['cid']; ?>">
          <div class="form-field-add-customer">
            <label for="customer-name">Customer Name</label>
            <input type="text" id="customer-name" name="customer-name" value="<?php echo $row['c_name']; ?>">
          </div>
          <div class="form-field-add-customer">
            <label for="phone-number">Phone Number</label>
            <input type="text" id="phone-number" name="phone-number" value="<?php echo $row['c_contact']; ?>">
          </div>
          <div class="form-field-add-customer">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo $row['c_address']; ?>">
          </div>
          <div class="form-field-add-customer">
            <label for="doctor-name">Doctor's Name</label>
            <input type="text" id="doctor-name" name="doctor-name" value="<?php echo $row['doctor_name']; ?>">
          </div>
          <button class="button-add-customer" type="submit" name="update">Edit Customer</button>
          <button class="button-delete-customer" type="submit" name="delete">Delete Customer</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
