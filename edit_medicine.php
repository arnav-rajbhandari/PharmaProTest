<!DOCTYPE html>
<html>
<head>
  <title>Edit Medicine</title>
  <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="css/medicine.css">
</head>
<body>
  <script src="script.js"></script>
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
              <li><a href="edit_medicine.php">Edit Medicine</a></li>
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
        <h1>Edit Medicine Data</h1>
      </div>
      <div class="medicine-container-depth-2-form">
        <?php
        include 'db_connect.php';

        if (isset($_GET['cid'])) {
          $med_id = mysqli_real_escape_string($conn, $_GET['cid']);
          $sql = "SELECT * FROM medicine WHERE med_id = $med_id";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
          } else {
            echo "No record found.";
            exit();
          }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
          $med_id = $_POST['med_id'];
          $med_name = $_POST['medicine-name'];
          $generic_name = $_POST['generic-name'];
          $med_company = $_POST['med-company'];
          $MRP = $_POST['MRP'];

          $sql = "UPDATE medicine SET med_name='$med_name', generic_name='$generic_name', med_company='$med_company', MRP='$MRP' WHERE med_id=$med_id";

          if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Record edited successfully.");</script>';
            header("Location: view_medicine.php");
            exit;
          } else {
            echo "Error updating record: " . mysqli_error($conn);
          }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
          $med_id = $_POST['med_id'];
          $sql = "DELETE FROM medicine WHERE med_id=$med_id";

          if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Record deleted successfully.");</script>';
            header("Location: view_medicine.php");
            exit;
          } else {
            echo "Error deleting record: " . mysqli_error($conn);
          }
        }

        mysqli_close($conn);
        ?>
        <form class="add-medicine-form" method="post" action="edit_medicine.php?cid=<?php echo $row['med_id']; ?>">
          <input type="hidden" name="med_id" value="<?php echo $row['med_id']; ?>">
          <div class="form-field-add-medicine">
            <label for="medicine-name">Medicine Name</label>
            <input type="text" id="medicine-name" name="medicine-name" value="<?php echo $row['med_name']; ?>" required>
          </div>
          <div class="form-field-add-medicine">
            <label for="generic-name">Generic Name</label>
            <input type="text" id="generic-name" name="generic-name" value="<?php echo $row['generic_name']; ?>" required>
          </div>
          <div class="form-field-add-medicine">
            <label for="med-company">Company Name</label>
            <input type="text" id="med-company" name="med-company" value="<?php echo $row['med_company']; ?>" required>
          </div>
          <div class="form-field-add-medicine">
            <label for="MRP">MRP</label>
            <input type="text" id="MRP" name="MRP" value="<?php echo $row['MRP']; ?>" required>
          </div>
          <button class="button-add-medicine" type="submit" name="update">Edit Medicine</button>
          <button class="button-delete-medicine" type="submit" name="delete">Delete Medicine</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
