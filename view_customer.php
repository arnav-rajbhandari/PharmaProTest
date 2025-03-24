<?php
?>
<html>
<head>
  <title>View Customers</title>
  <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="css/customer.css">
</head>
<body>
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
              <li><a href="#">Edit Customer</a></li>
            </ul>
          </div>
        </div>
        <div class="customer-nav-depth-3-logout">
          <a href="login.php">Log out</a>
        </div>
      </div>
    </div>

    <div class="customer-container-depth-1">
      <div class="customer-container-depth-2-head-cst">
        <h1>Customers</h1>
      </div>
      <div class="customer-container-depth-2-search-cst">
        <form action="view_customer.php" method="GET">
          <label for="search-customer">Search:</label>
          <input type="text" id="site-search" name="search-customer" value="<?php echo isset($_GET['search-customer']) ? htmlspecialchars($_GET['search-customer']) : ''; ?>" />
          <button type="submit">Search</button>
        </form>
      </div>
      <div class="customer-container-depth-2-content-cst">
        <div style="overflow-y: auto; height: 60%;">
          <table>
            <thead>
              <tr>
                <th class="sortable">CID</th>
                <th class="sortable">Customer Name</th>
                <th >Contact</th>
                <th class="sortable">Address</th>
                <th class="sortable">Doctor Name</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
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
            </tbody>
          </table>
        </div> 
      </div>
    </div>
  </div>
  <script src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

      const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
        v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
      )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

      document.querySelectorAll('th.sortable').forEach(th => th.addEventListener('click', function() {
        const table = th.closest('table');
        const tbody = table.querySelector('tbody');
        Array.from(tbody.querySelectorAll('tr'))
          .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
          .forEach(tr => tbody.appendChild(tr) );
      }));
    });
  </script>
</body>
</html>
