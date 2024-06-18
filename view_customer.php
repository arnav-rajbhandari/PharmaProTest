<?php
?>
<html>
<head>
  <title>View Customers</title>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="style-test.css">
</head>
<body>
 <script src="script.js"></script>
  <div class="depth-0">
      <div class="nav-depth-1">
        <div class="nav-depth-2">
          <div class="customer-nav-depth-3-links">
            <div class="customer-nav-depth-4-logo">
              <a href="#"><img src="home.png" class="home-logo-img"></a>
            </div>
            <div class="nav-depth-4-links">
              <ul class="nav-links">
                        <li><a href="add_customer.php">Add Customer</a></li>
                        <li><a href="view_customer.php">View Customer</a></li>
                        <li><a href="#">Edit Customer</a></li>
                    </ul>
            </div>
          </div>
          <div class="nav-depth-3-logout">
            <a href="login.php">Log out</a>
          </div>
        </div>
      </div>

      <div class="container-depth-1">
        <div class="container-depth-2-head-cst">
          <h1>Customers</h1>
        </div>
        <div class="container-depth-2-search-cst">
            <form action="view_customer.php" method="GET">
              <label for="search-customer">Search:</label>
              <input type="text" id="site-search" name="search-customer" value="<?php echo isset($_GET['search-customer']) ? htmlspecialchars($_GET['search-customer']) : ''; ?>" />
              <button type="submit">Search</button>
            </form>
        </div>
        <div class="container-depth-2-content-cst">
              <div style="overflow-y: auto; height: 60%;"> 
                <table>
                <tr>
                  <th>CID</th>
                  <th>Customer Name</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Doctor Name</th>
                  <th></th>
                </tr>
                <?php
            // PHP code to connect to database and retrieve records
            include 'db_connect.php';

            // Get the search input
            $search = isset($_GET['search-customer']) ? mysqli_real_escape_string($conn, $_GET['search-customer']) : '';

            // SQL query to fetch records
            $sql = "SELECT * FROM customer";
            if ($search != '') {
              $sql .= " WHERE c_name LIKE '%$search%' OR c_contact LIKE '%$search%' OR c_address LIKE '%$search%' OR doctor_name LIKE '%$search%'";
            }
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["cid"] . "</td>";
                echo "<td>" . $row["c_name"] . "</td>";
                echo "<td>" . $row["c_contact"] . "</td>";
                echo "<td>" . $row["c_address"] . "</td>";
                echo "<td>" . $row["doctor_name"] . "</td>";
                echo "<td><a href='edit_customer.php?cid=" . $row["cid"] . "'>Edit</a></td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='6'>0 results</td></tr>";
            }

            mysqli_close($conn);
            ?>
                
              </table>
            </div>
              
        </div>
      </div>
    </div>

</body>
</html>