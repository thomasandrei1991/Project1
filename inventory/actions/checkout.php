<?php

    require_once __DIR__ . '/../config/database.php';

    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)) {
        http_response_code(400);
        echo 'Invalid request payload';
        exit;
    }

    // First, check if all products have enough stock
    foreach ($data as $item) {
        $product_name = mysqli_real_escape_string($conn, $item['product']);
        $quantity = (int) $item['qty'];

        // Check current stock
        $stock_check = "SELECT stocks FROM products WHERE product_name = '{$product_name}'";
        $stock_result = mysqli_query($conn, $stock_check);
        
        if (!$stock_result || mysqli_num_rows($stock_result) == 0) {
            http_response_code(400);
            echo 'Product not found: ' . $product_name;
            exit;
        }

        $stock_row = mysqli_fetch_assoc($stock_result);
        $current_stock = (int) $stock_row['stocks'];

        if ($current_stock < $quantity) {
            http_response_code(400);
            echo 'Insufficient stock for: ' . $product_name . '. Available: ' . $current_stock . ', Requested: ' . $quantity;
            exit;
        }
    }

    // If all items have enough stock, proceed with the sale and update inventory
    foreach ($data as $item) {
        $product_name = mysqli_real_escape_string($conn, $item['product']);
        $quantity = (int) $item['qty'];
        $price = (float) $item['price'];

        $total = $price * $quantity;

        // Insert into sales table
        $sql = "INSERT INTO sales (product_name, quantity, price, total) VALUES ('{$product_name}', {$quantity}, {$price}, {$total})";

        if (!mysqli_query($conn, $sql)) {
            http_response_code(500);
            echo 'Database error: ' . mysqli_error($conn);
            exit;
        }

        // Update the inventory (reduce stock)
        $update_stock = "UPDATE products SET stocks = stocks - {$quantity} WHERE product_name = '{$product_name}'";
        
        if (!mysqli_query($conn, $update_stock)) {
            http_response_code(500);
            echo 'Failed to update inventory: ' . mysqli_error($conn);
            exit;
        }
    }

    echo 'Success';

?>