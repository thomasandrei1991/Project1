<?php
    session_start();
    if(!isset($_GET['id'])){
        header("Location: inventory.php");
        exit;
    }
    require_once __DIR__ . "/config/database.php";
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        header("Location: inventory.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Product</title>
        <link rel="stylesheet" href="assets/css/style.css">
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
                <h1>Edit Product</h1>
                <form action="actions/update_product.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>" required>
                    <input type="text" name="category" value="<?php echo $row['category']; ?>" required>
                    <input type="text" name="barcode" value="<?php echo $row['barcode']; ?>" required>
                    <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required>
                    <input type="number" name="stocks" value="<?php echo $row['stocks']; ?>" required>
                    <br><br>
                    <img src="assets/images/<?php echo $row['image']; ?>" width="150" alt="Product Image">
                    <br><br>
                    <input type="file" name="image">
                    <br><br>
                    <button type="submit" name="update_product">Update Product</button>
                </form>
            </div>
        </div>
    </body>
</html>
