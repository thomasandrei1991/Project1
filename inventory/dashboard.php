<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    require_once __DIR__ . "/config/database.php";

    /** @var mysqli $conn */

    // Total Sales
    $totalSalesQuery = "SELECT SUM(total) AS total_sales FROM sales";
    $totalSalesResult = mysqli_query($conn, $totalSalesQuery);
    $totalSalesRow = mysqli_fetch_assoc($totalSalesResult);
    $totalSales = $totalSalesRow['total_sales'] ?? 0;

    // Total Products
    $productQuery = "SELECT COUNT(*) AS total_products FROM products";
    $productResult = mysqli_query($conn, $productQuery);
    $productRow = mysqli_fetch_assoc($productResult);
    $totalProducts = $productRow['total_products'] ?? 0;

    // Total Transactions
    $transactionQuery = "SELECT COUNT(*) AS total_transactions FROM sales";
    $transactionResult = mysqli_query($conn, $transactionQuery);
    $transactionRow = mysqli_fetch_assoc($transactionResult);
    $totalTransactions = $transactionRow['total_transactions'] ?? 0;

    // Best Sellers
    $bestSellerQuery = "SELECT product_name, SUM(quantity) AS total_qty 
                        FROM sales 
                        GROUP BY product_name 
                        ORDER BY total_qty DESC 
                        LIMIT 5";
    $bestSellerResult = mysqli_query($conn, $bestSellerQuery);

    $labels = [];
    $data = [];

    while ($row = mysqli_fetch_assoc($bestSellerResult)) {
        $labels[] = $row['product_name'];
        $data[]   = (int)$row['total_qty'];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Dashboard</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="dashboard-container">
            <div class="sidebar">
                <h2>POS SYSTEM</h2>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="pos.php">POS</a></li>
                    <?php if($_SESSION['role'] == 'admin'){ ?>
                        <li><a href="inventory.php">Inventory</a></li>
                        <li><a href="reports.php">Reports</a></li>
                    <?php } ?>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="main-content">
                <h1>
                    Welcome,
                    <?php echo $_SESSION['username']; ?>
                    (<?php echo $_SESSION['role']; ?>)
                </h1>
                <div class="cards">
                    <div class="card">
                        <h3>Total Sales</h3>
                        <p>₱<?php echo number_format($totalSales, 2); ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Products</h3>
                        <p><?php echo $totalProducts; ?></p>
                     </div>
                    <div class="card">
                        <h3>Total Transactions</h3>
                        <p><?php echo $totalTransactions; ?></p>
                    </div>
                </div>
                <br><br>
                <div class="card">
                    <h2>Best Seller Products</h2>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
        <script>
            const ctx = document.getElementById('salesChart');
            new Chart(ctx, {
                type: 'bar',
                data: {

                    labels:
                    <?php echo json_encode($labels); ?>,

                    datasets: [{

                        label: 'Products Sold',

                        data:
                        <?php echo json_encode($data); ?>,

                        borderWidth: 1
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