<?php
    session_start();

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
        header("Location: login.php");
        exit;
    }

    require_once __DIR__ . "/config/database.php";

    /** @var mysqli $conn */   // ← Ito ang nag-aayos ng error sa Intelephense

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Inventory</title>
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
                <h1>Inventory Management</h1>
                <br>

                <!-- Add Product Form -->
                <form action="actions/add_product.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="product_name" placeholder="Product Name" required>
                    <input type="text" name="category" placeholder="Category" required>
                    <input type="number" step="0.01" name="price" placeholder="Price" required>
                    <input type="text" name="barcode" placeholder="Barcode" required>
                    <input type="number" name="stocks" placeholder="Stocks" required>
                    
                    <div class="file-input-wrapper">
                        <label for="productImage" class="file-btn">Choose file</label>
                        <span class="file-name">No file chosen</span>
                        <input id="productImage" type="file" name="image" required>
                    </div>
                    <button type="submit" name="add_product">Add Product</button>
                </form>

                <br><br>

                <!-- Table -->
                <table class="inventory-table">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Stocks</th>
                        <th>Actions</th>
                    </tr>
                    <?php 
                    $sql = "SELECT * FROM products";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        die("Database query failed: " . mysqli_error($conn));
                    }

                    while($row = mysqli_fetch_assoc($result)){ 
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td>₱<?php echo $row['price']; ?></td>
                        <td><?php echo $row['stocks']; ?></td>
                        <td class="actions">
                            <a class="action-btn edit-btn" href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a class="action-btn delete-btn" href="actions/delete_product.php?id=<?php echo $row['id']; ?>" 
                            onclick="return confirm('Delete this product?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const input = document.getElementById('productImage');
                const nameEl = document.querySelector('.file-name');
                if (input && nameEl) {
                    input.addEventListener('change', function () {
                        nameEl.textContent = input.files.length > 0 ? input.files[0].name : 'No file chosen';
                    });
                }
            });
        </script>
    </body>
</html>