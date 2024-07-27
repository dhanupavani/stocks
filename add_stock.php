<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $bought_at = filter_var($_POST['bought_at'], FILTER_VALIDATE_FLOAT);
    $investment_amount = filter_var($_POST['investment_amount'], FILTER_VALIDATE_FLOAT);
    $total_shares = filter_var($_POST['total_shares'], FILTER_VALIDATE_FLOAT);
    $target_price = filter_var($_POST['target_price'], FILTER_VALIDATE_FLOAT);

    // Automatically set the purchase_date to the current date
    $purchase_date = date('Y-m-d');

    if ($name && $bought_at && $investment_amount && $total_shares && $target_price) {
        $sql = "SELECT * FROM Stocks WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $existing_shares = $row['total_shares'];
            $existing_investment_amount = $row['investment_amount'];

            $new_total_shares = $existing_shares + $total_shares;
            $new_investment_amount = $existing_investment_amount + $investment_amount;
            $new_average_price = $new_investment_amount / $new_total_shares;

            $update_sql = "UPDATE Stocks SET total_shares = ?, investment_amount = ?, average_share_price = ?, target_price = ?, purchase_date = ? WHERE name = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ddddss", $new_total_shares, $new_investment_amount, $new_average_price, $target_price, $purchase_date, $name);

            if ($update_stmt->execute()) {
                $message = "Stock record updated successfully";

                // Update total investment in Total_Investment table
                $update_investment_sql = "UPDATE Total_Investment SET total_invested = total_invested + ? WHERE id = 1";
                $update_investment_stmt = $conn->prepare($update_investment_sql);
                if ($update_investment_stmt) {
                    $update_investment_stmt->bind_param("d", $investment_amount);
                    $update_investment_stmt->execute();
                    $update_investment_stmt->close();
                } else {
                    $message = "Error preparing update statement: " . $conn->error;
                }
            } else {
                $message = "Error updating record: " . $update_stmt->error;
            }
            $update_stmt->close();
        } else {
            $insert_sql = "INSERT INTO Stocks (name, Bought_At, investment_amount, total_shares, average_share_price, target_price, purchase_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sddddds", $name, $bought_at, $investment_amount, $total_shares, $bought_at, $target_price, $purchase_date);

            if ($insert_stmt->execute()) {
                $message = "New stock record created successfully";

                // Update total investment in Total_Investment table
                $update_investment_sql = "UPDATE Total_Investment SET total_invested = total_invested + ? WHERE id = 1";
                $update_investment_stmt = $conn->prepare($update_investment_sql);
                if ($update_investment_stmt) {
                    $update_investment_stmt->bind_param("d", $investment_amount);
                    $update_investment_stmt->execute();
                    $update_investment_stmt->close();
                } else {
                    $message = "Error preparing update statement: " . $conn->error;
                }
            } else {
                $message = "Error: " . $insert_stmt->error;
            }
            $insert_stmt->close();
        }
        $stmt->close();
    } else {
        $message = "Invalid input.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Stock</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function calculateShares() {
            var boughtAt = document.getElementById('bought_at').value;
            var investmentAmount = document.getElementById('investment_amount').value;
            var totalShares = 0;
            if (boughtAt && investmentAmount) {
                totalShares = investmentAmount / boughtAt;
            }
            document.getElementById('total_shares').value = totalShares.toFixed(2);
        }
    </script>
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
        <h1>Add New Stock</h1>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="add_stock.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <select id="name" name="name" required>
                    <?php
                    include('db_connect.php');
                    $sql = "SELECT name FROM all_stocks";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['name']}'>{$row['name']}</option>";
                        }
                    } else {
                        echo "<option value=''>No stocks available</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="bought_at">Price Per Share:</label>
                <input type="number" step="0.01" id="bought_at" name="bought_at" oninput="calculateShares()" required>
            </div>
            <div class="form-group">
                <label for="investment_amount">Investment Amount:</label>
                <input type="number" step="0.01" id="investment_amount" name="investment_amount" oninput="calculateShares()" required>
            </div>
            <div class="form-group">
                <label for="total_shares">Total Shares:</label>
                <input type="number" step="0.01" id="total_shares" name="total_shares" readonly required>
            </div>
            <div class="form-group">
                <label for="target_price">Target Price:</label>
                <input type="number" step="0.01" id="target_price" name="target_price" required>
            </div>
            <div class="form-group">
                <button type="submit">Add Stock</button>
            </div>
        </form>
    </main>
</body>
</html>

