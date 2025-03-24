<?php
include 'db_connect.php';

$query = $_GET['query'];

$medicines_result = $conn->query("
    SELECT ms.stock_id, ms.expiry_date, ms.quantity, ms.rate, m.med_id, m.med_name, m.MRP 
    FROM medicine_stock ms
    JOIN medicine m ON ms.med_id = m.med_id
    WHERE ms.quantity > 0 AND m.med_name LIKE '%$query%'
");

$medicines = $medicines_result->fetch_all(MYSQLI_ASSOC);

foreach ($medicines as $medicine):
?>
<tr>
    <td><?php echo $medicine['med_name']; ?></td>
    <td><?php echo $medicine['stock_id']; ?></td>
    <td><?php echo $medicine['expiry_date']; ?></td>
    <td><?php echo $medicine['quantity']; ?></td>
    <td><input type="number" name="quantity[]" min="1" max="<?php echo $medicine['quantity']; ?>"></td>
    <td><?php echo $medicine['rate']; ?></td>
    <td><?php echo $medicine['MRP']; ?></td>
    <td>
        <input type="checkbox" name="selected_medicines[]" value="<?php echo $medicine['med_id']; ?>" data-stock-id="<?php echo $medicine['stock_id']; ?>" data-rate="<?php echo $medicine['rate']; ?>">
    </td>
</tr>
<?php
endforeach;
?>
