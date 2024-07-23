<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocks Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa; /* Light blue background */
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #00796b; /* Dark teal background for header */
            color: white;
            padding: 10px 0;
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
            background-color: #004d40; /* Darker teal on hover */
            border-radius: 5px;
        }
        main {
            padding: 20px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 0 auto;
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
            background-color: #00796b; /* Match header background */
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0f2f1; /* Light teal on hover */
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
            </ul>
        </nav>
    </header>
    <main>
        <h1>Welcome to Stocks Management</h1>
        <h2>Total Stocks</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Bought At</th>
                <th>Investment Amount</th>
                <th>Total Shares</th>
                <th>Average Share Price</th>
                <th>Target Price</th>
                <th>Sold At</th>
                <th>Profit</th>
            </tr>
            <?php
            include('db_connect.php'); // Ensure this file has your DB connection details

            // Query to fetch stock records, excluding rows with NULL values
            $sql = "SELECT * FROM Stocks WHERE name IS NOT NULL";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $profit = ($row['Sold_At'] - $row['Bought_At']) * $row['total_shares'];
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['Bought_At']}</td>
                            <td>{$row['investment_amount']}</td>
                            <td>{$row['total_shares']}</td>
                            <td>{$row['average_share_price']}</td>
                            <td>{$row['target_price']}</td>
                            <td>{$row['Sold_At']}</td>
                            <td>{$profit}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No stocks found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </main>
</body>
</html>

