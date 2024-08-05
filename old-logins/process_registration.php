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
        $conn = new mysqli($servername, $root_user, $root_password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL statements to create user and database
        $sql_create_user_db = "
            CREATE DATABASE IF NOT EXISTS stock_monitoring_$username;
            CREATE USER IF NOT EXISTS '$username'@'localhost' IDENTIFIED BY '$password';
            GRANT ALL PRIVILEGES ON stock_monitoring_$username.* TO '$username'@'localhost';
            FLUSH PRIVILEGES;
        ";

        // Execute user and database creation
        if (!$conn->multi_query($sql_create_user_db)) {
            die("Error creating user and database: " . $conn->error);
        }

        // Wait for the queries to finish executing
        while ($conn->more_results() && $conn->next_result()) {
            // Do nothing, just wait
        }

        // Select the newly created database
        $conn->select_db("stock_monitoring_$username");

        // SQL statements to create tables
        $sql_create_tables = "
            CREATE TABLE IF NOT EXISTS `users` (
                `id` int NOT NULL AUTO_INCREMENT,
                `username` varchar(255) NOT NULL UNIQUE,
                `password` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `Investment_Track` (
                `id` int NOT NULL AUTO_INCREMENT,
                `Investment` decimal(10,2) DEFAULT NULL,
                `date` date DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `Sold_Stocks` (
                `id` int NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `released_money` decimal(10,2) NOT NULL,
                `profit_amount` decimal(10,2) NOT NULL,
                `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `Stocks` (
                `id` int NOT NULL AUTO_INCREMENT,
                `name` varchar(255) DEFAULT NULL,
                `Bought_At` decimal(10,2) DEFAULT NULL,
                `investment_amount` decimal(10,2) DEFAULT NULL,
                `total_shares` int DEFAULT NULL,
                `average_share_price` decimal(10,2) DEFAULT NULL,
                `target_price` decimal(10,2) DEFAULT NULL,
                `Sold_At` decimal(10,2) DEFAULT NULL,
                `purchase_date` date DEFAULT NULL,
                `is_deleted` tinyint(1) DEFAULT '0',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `Total_Investment` (
                `id` int NOT NULL AUTO_INCREMENT,
                `total_invested` decimal(15,2) NOT NULL DEFAULT '0.00',
                `total_profit_loss` decimal(10,2) DEFAULT NULL,
                `total_released_money` decimal(10,2) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `Transactions` (
                `id` int NOT NULL AUTO_INCREMENT,
                `stock_id` int DEFAULT NULL,
                `transaction_type` enum('buy','sell') DEFAULT NULL,
                `quantity` int DEFAULT NULL,
                `price` decimal(10,2) DEFAULT NULL,
                `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `stock_id` (`stock_id`),
                CONSTRAINT `fk_stock` FOREIGN KEY (`stock_id`) REFERENCES `Stocks` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `all_stocks` (
                `id` int NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            INSERT INTO `all_stocks` (`id`, `name`) VALUES
            (6, 'AWS'),
            (1, 'Stock A'),
            (2, 'Stock B'),
            (3, 'Stock C'),
            (4, 'Stock D'),
            (5, 'TATA STEEL'),
            (7, 'ZOMATO');
        ";

        // Execute table creation
        if (!$conn->multi_query($sql_create_tables)) {
            die("Error creating tables: " . $conn->error);
        }

        // Wait for the queries to finish executing
        while ($conn->more_results() && $conn->next_result()) {
            // Do nothing, just wait
        }

        // Insert the new user into the users table
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $username, $hashed_password);
            $stmt->execute();
            $stmt->close();
            $message = "User registered and database set up successfully.";
        } else {
            $message = "Error preparing statement: " . $conn->error;
        }

        echo "Message: " . htmlspecialchars($message) . "\n";

        $conn->close();
    } else {
        $message = "Please provide a username and password.";
    }

    // Redirect to registration page with a message
    header("Location: register.php?message=" . urlencode($message));
    exit();
}
?>

