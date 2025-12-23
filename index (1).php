<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "security_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SQL Injection Assignment 3</title>
</head>
<body>

<h2>Search User</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Enter username" required>
    <button type="submit" name="search">Search</button>
</form>

<hr>

<?php
if (isset($_POST['search'])) {

    $username = $_POST['username'];

    // Prepared Statement (Protection from SQL Injection)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h3>Search Result:</h3>";
        while ($row = $result->fetch_assoc()) {
            echo "Username: " . htmlspecialchars($row['username']) . "<br>";
            echo "Email: " . htmlspecialchars($row['email']) . "<hr>";
        }
    } else {
        echo "<p>No results found</p>";
    }

    $stmt->close();
}

$conn->close();
?>

</body>
</html>
