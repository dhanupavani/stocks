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
$monthly_investment = [];

// Fetch monthly released money, profit/loss data from Sold_Stocks
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

// Fetch monthly investment data from Investment_Track
$sql_investment = "
    SELECT
        DATE_FORMAT(date, '%Y-%m') AS month,
        SUM(Investment) AS total_investment
    FROM
        Investment_Track
    GROUP BY
        DATE_FORMAT(date, '%Y-%m')
    ORDER BY
        DATE_FORMAT(date, '%Y-%m') ASC";
$result_investment = $conn->query($sql_investment);

if ($result_investment === false) {
    die("Error fetching investment data: " . $conn->error);
}

$investment_data = [];
while ($row = $result_investment->fetch_assoc()) {
    $investment_data[$row['month']] = $row['total_investment'];
}

// Ensure all months are accounted for in the investment data
foreach ($months as $month) {
    if (isset($investment_data[$month])) {
        $monthly_investment[] = $investment_data[$month];
    } else {
        $monthly_investment[] = 0; // Default to 0 if no investment data is available for the month
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Bar Chart</title>
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
                <li><a href="chart2.php">Chart</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Monthly Performance Chart</h1>
        <canvas id="monthlyBarChart" width="800" height="400"></canvas>

        <script>
            const ctx = document.getElementById('monthlyBarChart').getContext('2d');
            const monthlyBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($months); ?>,
                    datasets: [
                        {
                            label: 'Investment (₹)',
                            data: <?php echo json_encode($monthly_investment); ?>,
                            backgroundColor: 'rgba(153, 102, 255, 0.6)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Released Money (₹)',
                            data: <?php echo json_encode($monthly_released_money); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Profit/Loss (₹)',
                            data: <?php echo json_encode($monthly_profit_loss); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Target Profit (₹)',
                            data: <?php echo json_encode($monthly_target); ?>,
                            backgroundColor: 'rgba(255, 206, 86, 0.6)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
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
                            stacked: false, // Set to false to separate the bars
                            display: true,
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            stacked: false, // Set to false to separate the bars
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

