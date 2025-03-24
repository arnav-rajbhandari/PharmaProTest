<?php
include 'db_connect.php';

// Fetch medicine stock information with medicine names
$search = isset($_GET['search-stock']) ? mysqli_real_escape_string($conn, $_GET['search-stock']) : '';
$sql = "SELECT ms.med_id, m.med_name, ms.batch_id, ms.expiry_date, ms.quantity, ms.stock_id, ms.rate
        FROM medicine_stock ms
        JOIN medicine m ON ms.med_id = m.med_id";
if ($search != '') {
    $sql .= " WHERE m.med_name LIKE '%$search%' OR ms.batch_id LIKE '%$search%'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Medicine Stock</title>
    <link href='https://fonts.googleapis.com/css?family=Manrope' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="css/medicine.css">
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
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
            <div class="medicine-container-depth-2-head-med">
                <h1>View Medicine Stock</h1>
            </div>
            <div class="medicine-container-depth-2-search-med">
                <form action="view_medicine_stock.php" method="GET">
                    <label for="search-stock">Search:</label>
                    <input type="text" id="site-search" name="search-stock" value="<?php echo isset($_GET['search-stock']) ? htmlspecialchars($_GET['search-stock']) : ''; ?>" />
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="medicine-container-depth-2-content-med">
                <div style="overflow-y:auto; ">
                    <table>
                        <thead>
                            <tr>
                                <th class="sortable">Medicine ID</th>
                                <th class="sortable">Medicine Name</th>
                                <th class="sortable">Batch ID</th>
                                <th class="sortable">Expiry Date</th>
                                <th class="sortable">Quantity</th>
                                <th class="sortable">Stock ID</th>
                                <th class="sortable">Rate</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row["med_id"] . "</td>";
                                    echo "<td>" . $row["med_name"] . "</td>";
                                    echo "<td>" . $row["batch_id"] . "</td>";
                                    echo "<td>" . $row["expiry_date"] . "</td>";
                                    echo "<td>" . $row["quantity"] . "</td>";
                                    echo "<td>" . $row["stock_id"] . "</td>";
                                    echo "<td>" . $row["rate"] . "</td>";
                                    echo "<td><a href='edit_medicine_stock.php?cid=" . $row["stock_id"] . "'>Edit</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No results found</td></tr>";
                            }

                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
      <script type="text/javascript">
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
