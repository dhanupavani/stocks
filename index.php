<?php
include('db_connect.php');

// Fetch total investment
$sql = "SELECT SUM(investment_amount) AS total_invested FROM Stocks WHERE name IS NOT NULL AND is_deleted = 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$total_invested = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_invested = $row['total_invested'];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocks Management</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
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
        .bold-text {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="total-investment">
        <p class="bold-text">Current Investment: ₹<?php echo number_format($total_invested, 2); ?></p>
    </div>

    <header>
        <h1>Stocks Management System</h1>
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
        <h2>Current Portfolio</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Purchase Date</th>
                    <th>Investment Amount</th>
                    <th>Average Share Price</th>
                    <th>Total Shares</th>
                    <th>Target Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch portfolio details
                $sql = "SELECT name, purchase_date, investment_amount, average_share_price, total_shares, target_price FROM Stocks WHERE is_deleted = 0";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['purchase_date']) . "</td>";
                        echo "<td>₹" . htmlspecialchars(number_format($row['investment_amount'], 2)) . "</td>";
                        echo "<td>₹" . htmlspecialchars(number_format($row['average_share_price'], 2)) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_shares']) . "</td>";
                        echo "<td>₹" . htmlspecialchars(number_format($row['target_price'], 2)) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No stocks found</td></tr>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>

