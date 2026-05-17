<?php

session_start();

require_once __DIR__ . "/config/database.php";

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

$totalSalesQuery =
"SELECT SUM(total) AS total_sales
 FROM sales";

$totalSalesResult =
mysqli_query($conn, $totalSalesQuery);

$totalSales =
mysqli_fetch_assoc($totalSalesResult);

$productQuery =
"SELECT COUNT(*) AS total_products
 FROM products";

$productResult =
mysqli_query($conn, $productQuery);

$totalProducts =
mysqli_fetch_assoc($productResult);

$transactionQuery =
"SELECT COUNT(*) AS total_transactions
 FROM sales";

$transactionResult =
mysqli_query($conn, $transactionQuery);

$totalTransactions =
mysqli_fetch_assoc($transactionResult);

?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard</title>

<link rel="stylesheet"
      href="assets/css/style.css">

</head>

<body>

<div class="dashboard-container">

<div class="sidebar">

<h2>POS SYSTEM</h2>

<ul>

<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="pos.php">POS</a></li>
<li><a href="inventory.php">Inventory</a></li>
<li><a href="reports.php">Reports</a></li>
<li><a href="logout.php">Logout</a></li>

</ul>

</div>

<div class="main-content">

<h1>
Welcome,
<?php echo $_SESSION['username']; ?>
</h1>

<div class="cards">

<div class="card">

<h3>Total Sales</h3>

<p>
₱<?php echo number_format($totalSales['total_sales'], 2); ?>
</p>

</div>

<div class="card">

<h3>Total Products</h3>

<p>
<?php echo $totalProducts['total_products']; ?>
</p>

</div>

<div class="card">

<h3>Total Transactions</h3>

<p>
<?php echo $totalTransactions['total_transactions']; ?>
</p>

</div>

</div>

</div>

</div>

</body>
</html>