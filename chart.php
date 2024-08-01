<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize arrays for storing monthly data
$months = [];
$monthly_released_money = [];
$monthly_profit_loss = [];
$monthly_target = [];

// Fetch monthly released money and profit/loss data
$sql_monthly = "
    SELECT
        DATE_FORMAT(sale_date, '%Y-%m') AS month,
        SUM(released_money) AS total_released_money,
        SUM(profit_amount) AS total_profit_loss
    FROM
        Sold_Stocks
    GROUP BY
        DATE_FORMAT(sale_date, '%Y-%m')
    ORDER BY
        DATE_FORMAT(sale_date, '%Y-%m') ASC";
$result_monthly = $conn->query($sql_monthly);

if ($result_monthly === false) {
    die("Error fetching monthly data: " . $conn->error);
}

while ($row = $result_monthly->fetch_assoc()) {
    $months[] = $row['month'];
    $monthly_released_money[] = $row['total_released_money'];
    $monthly_profit_loss[] = $row['total_profit_loss'];
    $monthly_target[] = $row['total_released_money'] * 0.05; // 5% of the released money as the target
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Chart</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <h1>Monthly Performance Chart</h1>
        <canvas id="monthlyChart" width="400" height="200"></canvas>

        <script>
            const ctx = document.getElementById('monthlyChart').getContext('2d');
            const monthlyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($months); ?>,
                    datasets: [
                        {
                            label: 'Released Money (₹)',
                            data: <?php echo json_encode($monthly_released_money); ?>,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: false,
                            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(75, 192, 192, 1)'
                        },
                        {
                            label: 'Profit/Loss (₹)',
                            data: <?php echo json_encode($monthly_profit_loss); ?>,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false,
                            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(255, 99, 132, 1)'
                        },
                        {
                            label: 'Target Profit (₹)',
                            data: <?php echo json_encode($monthly_target); ?>,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderDash: [5, 5],
                            fill: false,
                            pointBackgroundColor: 'rgba(255, 206, 86, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(255, 206, 86, 1)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        },
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Monthly Performance Overview'
                        }
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Amount (₹)'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </main>
</body>
</html>

