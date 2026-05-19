<?php

require_once __DIR__ . "/config/database.php";

echo "<h2>Database Debug</h2>";

// Check products
$result = mysqli_query($conn, "SELECT * FROM products LIMIT 5");
echo "<h3>Products in Database:</h3>";
if($result) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "Name: " . $row['product_name'] . ", Category: '" . $row['category'] . "', Price: " . $row['price'] . "<br>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Check categories
$categories = mysqli_query($conn, "SELECT DISTINCT category FROM products");
echo "<h3>All Categories:</h3>";
if($categories) {
    while($cat = mysqli_fetch_assoc($categories)) {
        echo "- '" . $cat['category'] . "'<br>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

?>
