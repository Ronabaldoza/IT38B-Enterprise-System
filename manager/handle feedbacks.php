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
    $name = $conn->real_escape_string($_POST['name']);
    $feedback = $conn->real_escape_string($_POST['feedback']);

    $sql = "INSERT INTO feedbacks (name, feedback) VALUES ('$name', '$feedback')";
    if ($conn->query($sql) === TRUE) {
        echo "Feedback submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$sql = "SELECT * FROM feedbacks ORDER BY created_at DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handle Feedbacks</title>
</head>
<body>
    <h1>Feedback Form</h1>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback" required></textarea>
        <br>
        <button type="submit">Submit Feedback</button>
    </form>

    <h2>All Feedbacks</h2>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while($row = $result->fetch_assoc()): ?>
                <li>
                    <strong><?php echo htmlspecialchars($row['name']); ?>:</strong>
                    <?php echo htmlspecialchars($row['feedback']); ?>
                    <em>(<?php echo $row['created_at']; ?>)</em>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No feedbacks found.</p>
    <?php endif; ?>
</body>
</html>
