<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

require_once __DIR__ . "/config/database.php";

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Inventory</title>

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

        <h1>Inventory Management</h1>

        <br>

        <form action="actions/add_product.php"
              method="POST">

            <input type="text"
                   name="product_name"
                   placeholder="Product Name"
                   required>

            <input type="number"
                   step="0.01"
                   name="price"
                   placeholder="Price"
                   required>

            <input type="number"
                   name="stocks"
                   placeholder="Stocks"
                   required>

            <button type="submit"
                    name="add_product">

                Add Product

            </button>

        </form>

        <br><br>

        <table border="1"
               width="100%"
               cellpadding="10">

            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stocks</th>
                <th>Action</th>
            </tr>

            <?php
            while($row = mysqli_fetch_assoc($result)){
            ?>

            <tr>

                <td>
                    <?php echo $row['id']; ?>
                </td>

                <td>
                    <?php echo $row['product_name']; ?>
                </td>

                <td>
                    ₱<?php echo $row['price']; ?>
                </td>

                <td>
                    <?php echo $row['stocks']; ?>
                </td>

                <td>

                    <a href="actions/delete_product.php?id=<?php echo $row['id']; ?>">
                        Delete
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>