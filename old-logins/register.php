ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    if ($username && $password) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Create a new MySQL user and database
        $conn->multi_query("
            CREATE USER IF NOT EXISTS '$username'@'localhost' IDENTIFIED BY '$password';
            CREATE DATABASE IF NOT EXISTS stock_monitoring_$username;
            USE stock_monitoring_$username;
            
            CREATE TABLE `Investment_Track` (
                `id` int NOT NULL AUTO_INCREMENT,
                `Investment` decimal(10,2) DEFAULT NULL,
                `date` date DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            
            CREATE TABLE `Sold_Stocks` (
                `id` int NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `released_money` decimal(10,2) NOT NULL,
                `profit_amount` decimal(10,2) NOT NULL,
                `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            
            CREATE TABLE `Stocks` (
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
            
            CREATE TABLE `Total_Investment` (
                `id` int NOT NULL AUTO_INCREMENT,
                `total_invested` decimal(15,2) NOT NULL DEFAULT '0.00',
                `total_profit_loss` decimal(10,2) DEFAULT NULL,
                `total_released_money` decimal(10,2) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            
            CREATE TABLE `Transactions` (
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
            
            CREATE TABLE `all_stocks` (
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
            
            GRANT ALL PRIVILEGES ON stock_monitoring_$username.* TO '$username'@'localhost';
            FLUSH PRIVILEGES;
        ");
        
        if ($conn->errno) {
            $message = "Error: " . $conn->error;
        } else {
            $message = "User registered successfully.";
        }
    } else {
        $message = "Please provide a username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Register</h1>
    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Register</button>
    </form>
</body>
</html>

