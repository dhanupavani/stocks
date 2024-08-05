<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    if ($username && $password) {
        // Database configuration
        $servername = "localhost";
        $root_user = "root"; // Assuming the root username is 'root'
        $root_password = "dhanu412"; // Your MySQL root password

        // Create a connection
        $conn = new mysqli($servername, $root_user, $root_password, "stock_monitoring_$username");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    // Password is correct, start a session and set session variables
                    session_start();
                    $_SESSION['username'] = $username;
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "Invalid username or password.";
                }
            } else {
                $message = "Invalid username or password.";
            }

            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
        }

        $conn->close();
    } else {
        $message = "Please provide a username and password.";
    }

    // Redirect back to login page with a message
    header("Location: login.php?message=" . urlencode($message));
    exit();
}
?>

