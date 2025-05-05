<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enterprise_system";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $order_id = $_POST['order_id'];
        $status = $conn->real_escape_string($_POST['status']);

        $sql = "UPDATE orders SET status='$status' WHERE id=$order_id";
        if ($conn->query($sql) === TRUE) {
            echo "Order status updated successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


$sql = "SELECT * FROM orders ORDER BY id ASC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
</head>
<body>
    <h1>Update Order Status</h1>

   
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Details</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_details']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                           
                            <form method="post" action="" style="display: inline;">
                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                <select name="status" required>
                                    <option value="Pending" <?php if ($row['status'] === 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Processing" <?php if ($row['status'] === 'Processing') echo 'selected'; ?>>Processing</option>
                                    <option value="Shipped" <?php if ($row['status'] === 'Shipped') echo 'selected'; ?>>Shipped</option>
                                    <option value="Delivered" <?php if ($row['status'] === 'Delivered') echo 'selected'; ?>>Delivered</option>
                                    <option value="Cancelled" <?php if ($row['status'] === 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                </select>
                                <button type="submit" name="update">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</body>
</html>
