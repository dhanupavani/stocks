<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

$sql = "SELECT t.*, s.name as stock_name FROM Transactions t JOIN Stocks s ON t.stock_id = s.id WHERE 1=1";
if ($start_date && $end_date) {
    $sql .= " AND t.transaction_date BETWEEN ? AND ?";
}
$sql .= " ORDER BY t.transaction_date DESC"; // Order by transaction_date

$stmt = $conn->prepare($sql);

if ($start_date && $end_date) {
    $stmt->bind_param("ss", $start_date, $end_date);
}

if (!$stmt->execute()) {
    die("Query failed: " . $stmt->error);
}

$result = $stmt->get_result();

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
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
                <li><a href="chart.php">Chart</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Report</h1>
        <form action="report.php" method="post">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
            </div>
            <div class="form-buttons">
                <input type="submit" value="Filter">
                <input type="reset" value="Clear">
            </div>
        </form>

        <h2>Transaction Overview</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Stock Name</th>
                    <th>Transaction Type</th>
                    <th>Price</th>
                    <th>Shares</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['stock_name']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['transaction_type']); ?></td>
                        <td>₹<?php echo number_format($transaction['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($transaction['quantity']); ?></td>
                        <td>₹<?php echo number_format($transaction['price'] * $transaction['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($transactions)): ?>
                    <tr><td colspan="6">No transactions found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

