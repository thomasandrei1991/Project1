<?php
    session_start();
    require_once __DIR__ . "/../../config/database.php";

    /** @var mysqli $conn */

    // Security: Sanitize ID
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id <= 0) {
        die("Invalid Product ID");
    }

    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$row) {
        die("Product not found!");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Product</title>
        <link rel="stylesheet" href="../../assets/css/style.css">
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

                    <label>Product Name:</label><br>
                    <input type="text" name="product_name" value="<?php echo htmlspecialchars($row['product_name']); ?>" required><br><br>

                    <label>Category:</label><br>
                    <input type="text" name="category" value="<?php echo htmlspecialchars($row['category']); ?>" required><br><br>

                    <label>Barcode:</label><br>
                    <input type="text" name="barcode" value="<?php echo htmlspecialchars($row['barcode']); ?>" required><br><br>

                    <label>Price:</label><br>
                    <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required><br><br>

                    <label>Stocks:</label><br>
                    <input type="number" name="stocks" value="<?php echo $row['stocks']; ?>" required><br><br>

                    <label>Current Image:</label><br>
                    <?php if (!empty($row['image'])): ?>
                        <img src="../../assets/images/<?php echo htmlspecialchars($row['image']); ?>" width="150" alt="Current Image"><br><br>
                    <?php else: ?>
                        <p><em>No image available</em></p><br>
                    <?php endif; ?>

                    <label>New Image (optional):</label><br>
                    <input type="file" name="image" accept="image/*"><br><br>

                    <button type="submit" name="update_product">Update Product</button>
                </form>
            </div>
        </div>
    </body>
</html>