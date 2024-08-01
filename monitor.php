<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize variables
$total_invested = 0;
$total_released_money = 0;
$total_profit_loss = 0;

// Fetch total investment from Total_Investment table
$sql_invested = "SELECT total_invested AS total_invested FROM Total_Investment WHERE id = 1";
$result_invested = $conn->query($sql_invested);

// Check if the query was successful
if ($result_invested === false) {
    die("Error fetching total invested amount: " . $conn->error);
}

if ($result_invested->num_rows > 0) {
    $row_invested = $result_invested->fetch_assoc();
    $total_invested = $row_invested['total_invested'];
}

// Fetch total released money and profit/loss from Sold_Stocks table
$sql_sold = "SELECT SUM(released_money) AS total_released_money, SUM(profit_amount) AS total_profit_loss FROM Sold_Stocks";
$result_sold = $conn->query($sql_sold);

// Check if the query was successful
if ($result_sold === false) {
    die("Error fetching total released money and profit/loss: " . $conn->error);
}

if ($result_sold->num_rows > 0) {
    $row_sold = $result_sold->fetch_assoc();
    $total_released_money = $row_sold['total_released_money'];
    $total_profit_loss = $row_sold['total_profit_loss'];
}

// Fetch details of all sold stocks
$sql_details = "SELECT * FROM Sold_Stocks ORDER BY sale_date DESC";
$result_details = $conn->query($sql_details);

// Check if the query was successful
if ($result_details === false) {
    die("Error fetching sold stocks details: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center; /* Center-align text */
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #00796b;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0f2f1;
        }
    </style>
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
        <h1>Monitor Portfolio</h1>
        <p>Total Invested: ₹<?php echo number_format($total_invested, 2); ?></p>
        <p>Total Released Money: ₹<?php echo number_format($total_released_money, 2); ?></p>
        <p>Total Profit/Loss: ₹<?php echo number_format($total_profit_loss, 2); ?></p>

        <h2>Sold Stocks Details</h2>
        <table>
            <tr>
                <th>Stock Name</th>
                <th>Released Money</th>
                <th>Profit/Loss</th>
                <th>Sale Date</th>
            </tr>
            <?php if ($result_details->num_rows > 0): ?>
                <?php while ($row = $result_details->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>₹<?php echo number_format($row['released_money'], 2); ?></td>
                        <td>₹<?php echo number_format($row['profit_amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No sold stocks found</td>
                </tr>
            <?php endif; ?>
        </table>
    </main>
</body>
</html>

