<?php
// charts.php

// Include the database connection file
include 'db_connect.php';

// Fetch data for released amount and profits
$sql = "SELECT date, released_amount, profit FROM your_table_name";
$result = $conn->query($sql);

$dates = [];
$released_amounts = [];
$profits = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $dates[] = $row['date'];
        $released_amounts[] = $row['released_amount'];
        $profits[] = $row['profit'];
    }
} else {
    echo "0 results";
}
$conn->close();

// Convert PHP arrays to JSON for use in JavaScript
$dates_json = json_encode($dates);
$released_amounts_json = json_encode($released_amounts);
$profits_json = json_encode($profits);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock Monitor Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Released Amount and Profit Charts</h1>
    <canvas id="barChart"></canvas>
    <canvas id="lineChart"></canvas>
    <script>
        // Use the PHP-generated JSON data in JavaScript
        const dates = <?php echo $dates_json; ?>;
        const releasedAmounts = <?php echo $released_amounts_json; ?>;
        const profits = <?php echo $profits_json; ?>;

        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [
                    {
                        label: 'Released Amount',
                        data: releasedAmounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Profit',
                        data: profits,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Line Chart
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [
                    {
                        label: 'Released Amount',
                        data: releasedAmounts,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        borderWidth: 1
                    },
                    {
                        label: 'Profit',
                        data: profits,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

