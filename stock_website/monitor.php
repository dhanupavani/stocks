<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize variables
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Prepare SQL query with date range filter
$sql = "SELECT * FROM Sold_Stocks";
if ($start_date && $end_date) {
    $sql .= " WHERE sale_date BETWEEN ? AND ?";
}
$stmt = $conn->prepare($sql);

if ($start_date && $end_date) {
    $stmt->bind_param("ss", $start_date, $end_date);
}

$stmt->execute();
$result = $stmt->get_result();

$total_released_money = 0;
$total_profit_loss = 0;
$sold_stocks = [];

while ($row = $result->fetch_assoc()) {
    $sold_stocks[] = $row;
    $total_released_money += $row['released_money'];
    $total_profit_loss += $row['profit_amount'];
}

// Calculate percentages
$profit_percentage = ($total_released_money > 0) ? ($total_profit_loss / $total_released_money) * 100 : 0;
$profit_percentage = number_format($profit_percentage, 2);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Sold Stocks</title>
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
        <h1>Monitor Sold Stocks</h1>
        <form action="monitor.php" method="post">
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

        <h2>Sold Stocks Overview</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Released Money</th>
                <th>Profit Amount</th>
                <th>Profit Percentage</th>
                <th>Sale Date</th>
            </tr>
            <?php foreach ($sold_stocks as $stock): ?>
                <tr>
                    <td><?php echo htmlspecialchars($stock['name']); ?></td>
                    <td><?php echo number_format($stock['released_money'], 2); ?></td>
                    <td><?php echo number_format($stock['profit_amount'], 2); ?></td>
                    <td><?php echo number_format(($stock['profit_amount'] / $stock['released_money']) * 100, 2); ?>%</td>
                    <td><?php echo htmlspecialchars($stock['sale_date']); ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($sold_stocks)): ?>
                <tr><td colspan="5">No sold stocks found</td></tr>
            <?php endif; ?>
        </table>

        <h3>Total Released Money: ₹<?php echo number_format($total_released_money, 2); ?></h3>
        <h3>Total Profit/Loss: ₹<?php echo number_format($total_profit_loss, 2); ?></h3>
        <h3>Overall Profit Percentage: <?php echo $profit_percentage; ?>%</h3>
    </main>
</body>
</html>

