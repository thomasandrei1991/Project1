<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
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

        <h1>
            Welcome,
            <?php echo $_SESSION['username']; ?>
        </h1>

        <div class="cards">

            <div class="card">
                <h3>Total Sales</h3>
                <p>₱15,000</p>
            </div>

            <div class="card">
                <h3>Total Products</h3>
                <p>150</p>
            </div>

            <div class="card">
                <h3>Total Transactions</h3>
                <p>320</p>
            </div>

        </div>

    </div>

</div>

</body>
</html>