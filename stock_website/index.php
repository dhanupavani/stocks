<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocks Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        header {
            background-color: #00796b;
            color: white;
            padding: 10px 0;
            width: 100%;
            text-align: center;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 10px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        nav ul li a:hover {
            background-color: #004d40;
            border-radius: 5px;
        }
        main {
            padding: 20px;
            text-align: center;
            width: 80%;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
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
        .total-investment {
            position: absolute;
            left: 20px;
            top: 60px;
            background-color: #004d40;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php
    include('db_connect.php');

    $sql = "SELECT SUM(investment_amount) AS total_invested FROM Stocks WHERE name IS NOT NULL";
    $result = $conn->query($sql);
    $total_invested = 0;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_invested = $row['total_invested'];
    }

    $conn->close();
    ?>
    <div class="total-investment">
        <p>Total Investment: ₹<?php echo number_format($total_invested, 2); ?></p>
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
                    <th>Total Shares</th>
                    <th>Investment Amount</th>
                    <th>Average Share Price</th>
                    <th>Target Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('db_connect.php');

                $sql = "SELECT name, total_shares, investment_amount, average_share_price, target_price FROM Stocks";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_shares']) . "</td>";
                        echo "<td>₹" . htmlspecialchars(number_format($row['investment_amount'], 2)) . "</td>";
                        echo "<td>₹" . htmlspecialchars(number_format($row['average_share_price'], 2)) . "</td>";
                        echo "<td>₹" . htmlspecialchars(number_format($row['target_price'], 2)) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No stocks found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>

