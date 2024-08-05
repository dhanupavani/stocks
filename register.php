<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $conn = new mysqli('localhost', 'root', 'dhanu412');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create the user
    $sql = "CREATE USER IF NOT EXISTS '$user'@'localhost' IDENTIFIED BY '$pass'";
    if ($conn->query($sql) !== TRUE) {
        die("Error creating user: " . $conn->error);
    }

    // Create the database
    $sql = "CREATE DATABASE IF NOT EXISTS stock_monitoring_$user";
    if ($conn->query($sql) !== TRUE) {
        die("Error creating database: " . $conn->error);
    }

    // Grant permissions
    $sql = "GRANT ALL PRIVILEGES ON stock_monitoring_$user.* TO '$user'@'localhost'";
    if ($conn->query($sql) !== TRUE) {
        die("Error granting permissions: " . $conn->error);
    }

    // Create necessary tables
    $conn->select_db("stock_monitoring_$user");
    $sql = file_get_contents('create_tables.sql'); // Assuming you have the table creation SQL in this file
    if ($conn->multi_query($sql) !== TRUE) {
        die("Error creating tables: " . $conn->error);
    }

    echo "User registered successfully.";
}
?>

<form method="post" action="register.php">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Register">
</form>

