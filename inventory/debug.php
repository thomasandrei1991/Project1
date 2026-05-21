<?php
    require_once __DIR__ . "/config/database.php";

    /** @var mysqli $conn */
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Database Debug</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
            table { border-collapse: collapse; width: 100%; margin-top: 20px; }
            th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
            th { background: #2c3e50; color: white; }
            .success { color: green; }
            .error { color: red; }
        </style>
    </head>
    <body>
        <h2>Database Debug Information</h2>

        <?php
            // Check if connection is working
            if (!$conn) {
                die("<p class='error'>Database Connection Failed!</p>");
            } else {
                echo "<p class='success'>✅ Database Connected Successfully</p>";
            }

            // Check Products
            echo "<h3>Products in Database (Latest 10):</h3>";
            $result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 10");
            
            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Product Name</th><th>Category</th><th>Price</th><th>Stocks</th><th>Image</th><th>Barcode</th></tr>";
                
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                    echo "<td>₱" . $row['price'] . "</td>";
                    echo "<td>" . $row['stocks'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['image'] ?? 'No Image') . "</td>";
                    echo "<td>" . htmlspecialchars($row['barcode'] ?? '') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='error'>No products found or query error: " . mysqli_error($conn) . "</p>";
            }

            // Check Categories
            echo "<h3>Distinct Categories:</h3>";
            $categories = mysqli_query($conn, "SELECT DISTINCT category FROM products ORDER BY category ASC");
            
            if ($categories && mysqli_num_rows($categories) > 0) {
                echo "<ul>";
                while($cat = mysqli_fetch_assoc($categories)) {
                    echo "<li><strong>" . htmlspecialchars($cat['category']) . "</strong></li>";
                }
                echo "</ul>";
            } else {
                echo "<p class='error'>No categories found.</p>";
            }

            // Check table structure
            echo "<h3>Table Structure (products):</h3>";
            $structure = mysqli_query($conn, "SHOW COLUMNS FROM products");
            if ($structure) {
                echo "<table>";
                echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
                while($col = mysqli_fetch_assoc($structure)) {
                    echo "<tr>";
                    echo "<td>" . $col['Field'] . "</td>";
                    echo "<td>" . $col['Type'] . "</td>";
                    echo "<td>" . $col['Null'] . "</td>";
                    echo "<td>" . $col['Key'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
    </body>
</html>