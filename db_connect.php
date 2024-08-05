<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in and has a valid session
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    die("User not logged in");
}

// Retrieve the username and password from the session
$username = $_SESSION['username'];
$password = $_SESSION['password'];

// Database configuration
$servername = "localhost"; // or your database server's address

// Construct the database name dynamically based on the logged-in user
$database = "stock_monitoring_" . $username;

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Uncomment the line below for debugging purposes (not recommended for production)
// echo "Connected successfully";
?>

