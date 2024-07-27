<?php
// Database configuration
$servername = "localhost"; // or your database server's address
$username = "dhanu"; // Your MySQL username
$password = "dhanu412"; // Your MySQL password
$database = "stock_monitoring"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Uncomment the line below for debugging purposes (not recommended for production)
// echo "Connected successfully";
?>

