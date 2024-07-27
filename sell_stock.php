<?php
date_default_timezone_set('Asia/Kolkata');
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $sold_at = $_POST['sold_at'];
    $shares_sold = $_POST['shares_sold'];
    $sale_date = date('Y-m-d H:i:s'); // Current date and time

    // Check if the stock exists and get the current details
    $sql = "SELECT * FROM Stocks WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_shares = $row['total_shares'];
        $average_share_price = $row['average_share_price'];
        $current_investment = $row['investment_amount'];

        if ($shares_sold <= $current_shares) {
            $remaining_shares = $current_shares - $shares_sold;
            $released_money = $average_share_price * $shares_sold; // Use the original purchase price
            $profit_amount = ($sold_at - $average_share_price) * $shares_sold;
            $new_investment_amount = $current_investment - $released_money;

            if ($remaining_shares > 0) {
                // Update the stock record
                $update_sql = "UPDATE Stocks SET total_shares = ?, investment_amount = ? WHERE name = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("dds", $remaining_shares, $new_investment_amount, $name);

                if ($update_stmt->execute()) {
                    // Insert sold stock details into Sold_Stocks table
                    $insert_sql = "INSERT INTO Sold_Stocks (name, released_money, profit_amount, sale_date) VALUES (?, ?, ?, ?)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param("sdds", $name, $released_money, $profit_amount, $sale_date);

                    if ($insert_stmt->execute()) {
                        $message = "Stock sold and recorded successfully. Released Money: ₹{$released_money}, Profit: ₹{$profit_amount}";
                    } else {
                        $message = "Error inserting sold stock: " . $insert_stmt->error;
                    }

                    $insert_stmt->close();
                } else {
                    $message = "Error updating stock record: " . $update_stmt->error;
                }

                $update_stmt->close();
            } else {
                // Delete the stock record if remaining shares are zero
                $delete_sql = "DELETE FROM Stocks WHERE name = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("s", $name);

                if ($delete_stmt->execute()) {
                    // Insert sold stock details into Sold_Stocks table
                    $insert_sql = "INSERT INTO Sold_Stocks (name, released_money, profit_amount, sale_date) VALUES (?, ?, ?, ?)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param("sdds", $name, $released_money, $profit_amount, $sale_date);

                    if ($insert_stmt->execute()) {
                        $message = "Stock sold and recorded successfully. Released Money: ₹{$released_money}, Profit: ₹{$profit_amount}";
                    } else {
                        $message = "Error inserting sold stock: " . $insert_stmt->error;
                    }

                    $insert_stmt->close();
                } else {
                    $message = "Error deleting stock record: " . $delete_stmt->error;
                }

                $delete_stmt->close();
            }
        } else {
            $message = "Error: You don't have enough shares to sell.";
        }
    } else {
        $message = "Error: Stock not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Stock</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="add_stock.php">Add New Stocks</a></li>
                <li><a href="sell_stock.php">Sell Stocks</a></li>
                <li><a href="monitor.php">Monitor</a></li>
                <li><a href="report.php">Report</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Sell Stock</h1>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="sell_stock.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <select id="name" name="name" required>
                    <?php
                    $sql = "SELECT name FROM Stocks WHERE total_shares > 0";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['name']}'>{$row['name']}</option>";
                        }
                    } else {
                        echo "<option value=''>No stocks available</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="sold_at">Sold At:</label>
                <input type="number" id="sold_at" name="sold_at" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="shares_sold">Shares Sold:</label>
                <input type="number" id="shares_sold" name="shares_sold" required>
            </div>

            <div class="form-buttons">
                <input type="submit" value="Sell Stock">
                <input type="reset" value="Clear">
            </div>
        </form>
    </main>
</body>
</html>

