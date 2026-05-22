<?php

session_start();

require_once __DIR__ . "/config/database.php";

/** @var mysqli $conn */


if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

// TOTAL SALES TODAY
$todaySalesQuery = "
SELECT SUM(total) AS today_sales
FROM sales
WHERE DATE(created_at) = CURDATE()
";

$todaySalesResult =
mysqli_query($conn, $todaySalesQuery);

$todaySales =
mysqli_fetch_assoc($todaySalesResult);

// TOTAL TRANSACTIONS TODAY
$transactionQuery = "
SELECT COUNT(*) AS total_transactions
FROM sales
WHERE DATE(created_at) = CURDATE()
";

$transactionResult =
mysqli_query($conn, $transactionQuery);

$totalTransactions =
mysqli_fetch_assoc($transactionResult);

// BEST SELLER
$bestSellerQuery = "
SELECT product_name,
SUM(quantity) AS total_qty

FROM sales

GROUP BY product_name

ORDER BY total_qty DESC

LIMIT 5
";

$bestSellerResult =
mysqli_query($conn, $bestSellerQuery);

// SALES PER DAY CHART
$chartQuery = "
SELECT DATE(created_at) AS sale_date,
SUM(total) AS total_sales

FROM sales

GROUP BY DATE(created_at)

ORDER BY sale_date ASC
";

$chartResult =
mysqli_query($conn, $chartQuery);

$labels = [];
$data = [];

while($row = mysqli_fetch_assoc($chartResult)){

    $labels[] = $row['sale_date'];

    $data[] = $row['total_sales'];

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Reports</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body>

<div class="dashboard-container">

    <div class="sidebar">

        <h2>POS SYSTEM</h2>

        <ul>

            <li>
                <a href="dashboard.php">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="pos.php">
                    POS
                </a>
            </li>

            <li>
                <a href="inventory.php">
                    Inventory
                </a>
            </li>

            <li>
                <a href="reports.php">
                    Reports
                </a>
            </li>

            <li>
                <a href="logout.php">
                    Logout
                </a>
            </li>

        </ul>

    </div>

    <div class="main-content">

        <h1>Sales Reports</h1>
        <br>
        <a href="export_sales.php"><button>Export Excel / CSV</button></a>
        <div class="cards">

            <div class="card">

                <h3>Today's Sales</h3>

                <p>
                    ₱<?php
                    echo number_format(
                        $todaySales['today_sales'],
                        2
                    );
                    ?>
                </p>

            </div>

            <div class="card">

                <h3>Transactions Today</h3>

                <p>
                    <?php
                    echo $totalTransactions['total_transactions'];
                    ?>
                </p>

            </div>

        </div>

        <br><br>

        <div class="card">

            <h2>Best Seller Products</h2>

            <table width="100%">

                <tr>
                    <th>Product</th>
                    <th>Sold</th>
                </tr>

                <?php while($best = mysqli_fetch_assoc($bestSellerResult)){ ?>

                <tr>

                    <td>
                        <?php echo $best['product_name']; ?>
                    </td>

                    <td>
                        <?php echo $best['total_qty']; ?>
                    </td>

                </tr>

                <?php } ?>

            </table>

        </div>

        <br><br>

        <div class="card">

            <h2>Sales Per Day</h2>

            <canvas id="salesChart"></canvas>

        </div>

    </div>

</div>

<script>

const ctx =
document.getElementById('salesChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels:
        <?php echo json_encode($labels); ?>,

        datasets: [{

            label: 'Sales',

            data:
            <?php echo json_encode($data); ?>,

            borderWidth: 3,
            tension: 0.3

        }]

    },

    options: {

        responsive: true,

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