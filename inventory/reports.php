<?php

    session_start();
    if($_SESSION['role'] != 'admin'){
        header("Location: pos.php");
    }
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    require_once __DIR__ . "/config/database.php";

    $sql = "SELECT * FROM sales ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reports</title>
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
                <h1>Sales Reports</h1>
                <br>
                <table width="100%" border="1" cellpadding="10">
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                    <?php while($row = mysqli_fetch_assoc($result)){?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>₱<?php echo $row['price']; ?></td>
                        <td>₱<?php echo $row['total']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </body>
</html>