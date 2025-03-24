<!DOCTYPE html>
<html>
<head>
    <title>Add Medicine</title>
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
                <h1>Medicines</h1>
            </div>
            <div class="medicine-container-depth-2-search-med">
                <form action="view_medicine.php" method="GET">
                    <input
                      type="text"
                      placeholder="Search by name"
                      class="w-full p-2 pl-10 border border-zinc-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-zinc-700 dark:border-zinc-600 dark:text-zinc-300"
                    />
                </form>
            </div>
            <div class="medicine-container-depth-2-content-med">
                <div style="height: 100%; overflow-y: auto;">
                
                    <table>
                        <thead>
                            <tr>
                                <th class="sortable" data-column="med_name">Medicine ID</th>
                                <th class="sortable" data-column="med_name">Medicine Name</th>
                                <th class="sortable" data-column="generic_name">Generic Name</th>
                                <th class="sortable" data-column="med_company">Company</th>
                                <th class="sortable" data-column="med_company">MRP</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // PHP code to connect to database and retrieve records
                                include 'db_connect.php';

                                // Get the search input
                                $search = isset($_GET['search-medicine']) ? mysqli_real_escape_string($conn, $_GET['search-medicine']) : '';

                                // SQL query to fetch records
                                $sql = "SELECT * FROM medicine";
                                if ($search != '') {
                                    $sql .= " WHERE med_name LIKE '%$search%' OR generic_name LIKE '%$search%'";
                                }
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row["med_id"] . "</td>";
                                        echo "<td>" . $row["med_name"] . "</td>";
                                        echo "<td>" . $row["generic_name"] . "</td>";
                                        echo "<td>" . $row["med_company"] . "</td>";
                                        echo "<td>" . $row["MRP"] . "</td>";
                                        echo "<td><a href='edit_medicine.php?cid=" . $row["med_id"] . "'>Edit</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No results found</td></tr>";
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
