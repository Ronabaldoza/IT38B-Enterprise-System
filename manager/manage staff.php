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
    if (isset($_POST['add'])) {
        
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $position = $conn->real_escape_string($_POST['position']);

        $sql = "INSERT INTO staff (name, email, position) VALUES ('$name', '$email', '$position')";
        if ($conn->query($sql) === TRUE) {
            echo "Staff added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        
        $id = $_POST['id'];
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $position = $conn->real_escape_string($_POST['position']);

        $sql = "UPDATE staff SET name='$name', email='$email', position='$position' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Staff updated successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
       
        $id = $_POST['id'];
        $sql = "DELETE FROM staff WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Staff deleted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


$sql = "SELECT * FROM staff ORDER BY id ASC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff</title>
</head>
<body>
    <h1>Manage Staff</h1>

   
    <h2>Add New Staff</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="position">Position:</label>
        <input type="text" id="position" name="position" required>
        <br>
        <button type="submit" name="add">Add Staff</button>
    </form>

    
    <h2>Staff List</h2>
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['position']); ?></td>
                        <td>
                            
                            <form method="post" action="" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                <input type="text" name="position" value="<?php echo htmlspecialchars($row['position']); ?>" required>
                                <button type="submit" name="update">Update</button>
                            </form>
                            
                            <form method="post" action="" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No staff members found.</p>
    <?php endif; ?>
</body>
</html>
