<?php
include 'db_connect.php'; // Database connection

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $bought_at = $_POST['bought_at'];
    $investment_amount = $_POST['investment_amount'];
    $total_shares = $_POST['total_shares'];
    $target_price = $_POST['target_price'];

    // Check if the stock exists
    $sql = "SELECT * FROM Stocks WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name); // The name is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Stock exists, update the existing record
        $row = $result->fetch_assoc();
        $existing_shares = $row['total_shares'];
        $existing_investment_amount = $row['investment_amount'];

        // Update total shares and average share price
        $new_total_shares = $existing_shares + $total_shares;
        $new_investment_amount = $existing_investment_amount + $investment_amount;
        $new_average_price = $new_investment_amount / $new_total_shares;

        $update_sql = "UPDATE Stocks SET total_shares = ?, investment_amount = ?, average_share_price = ?, target_price = ? WHERE name = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("dddds", $new_total_shares, $new_investment_amount, $new_average_price, $target_price, $name); // Use the correct types: double, double, double, double, string

        if ($update_stmt->execute()) {
            $message = "Stock record updated successfully";
        } else {
            $message = "Error updating record: " . $update_stmt->error;
        }

        $update_stmt->close();
    } else {
        // Stock does not exist, insert a new record
        $insert_sql = "INSERT INTO Stocks (name, Bought_At, investment_amount, total_shares, average_share_price, target_price) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sddddd", $name, $bought_at, $investment_amount, $total_shares, $bought_at, $target_price); // Use the correct types: string, double, double, double, double, double

        if ($insert_stmt->execute()) {
            $message = "New stock record created successfully";
        } else {
            $message = "Error: " . $insert_stmt->error;
        }

        $insert_stmt->close();
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
                <label for="bought_at">Bought At:</label>
                <input type="number" id="bought_at" name="bought_at" step="0.01" required oninput="calculateShares()">
            </div>

            <div class="form-group">
                <label for="investment_amount">Investment Amount:</label>
                <input type="number" id="investment_amount" name="investment_amount" step="0.01" required oninput="calculateShares()">
            </div>

            <div class="form-group">
                <label for="total_shares">Total Shares:</label>
                <input type="number" id="total_shares" name="total_shares" step="0.01" readonly required>
            </div>

            <div class="form-group">
                <label for="target_price">Target Price:</label>
                <input type="number" id="target_price" name="target_price" step="0.01" required>
            </div>

            <div class="form-buttons">
                <input type="submit" value="Add Stock">
                <input type="reset" value="Clear">
            </div>
        </form>
    </main>
</body>
</html>

