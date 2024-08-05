<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    if ($username && $password) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Database configuration
        $servername = "localhost";
        $root_user = "root"; // Assuming the root username is 'root'
        $root_password = "dhanu412"; // Your MySQL root password

        // Create connection
        $conn = new mysqli($servername, $root_user, $root_password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Use multi_query for creating user, database, and tables
        $sql = "
            CREATE USER IF NOT EXISTS '$username'@'localhost' IDENTIFIED BY '$password';
            CREATE DATABASE IF NOT EXISTS stock_monitoring_$username;
            GRANT ALL PRIVILEGES ON stock_monitoring_$username.* TO '$username'@'localhost';
            FLUSH PRIVILEGES;
            
            USE stock_monitoring_$username;

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

            CREATE TABLE IF NOT EXISTS `users` (
                `id` int NOT NULL AUTO_INCREMENT,
                `username` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `username` (`username`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            INSERT INTO users (username, password) VALUES ('$username', '$hashed_password');
        ";

        if ($conn->multi_query($sql)) {
            do {
                if ($conn->errno) {
                    echo "Error: " . $conn->error . "<br>";
                }
            } while ($conn->more_results() && $conn->next_result());
            echo "User registered and database set up successfully.";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Please provide a username and password.";
    }
}
?>

