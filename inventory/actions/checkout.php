<?php

require_once __DIR__ . '/../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data)) {
    http_response_code(400);
    echo 'Invalid request payload';
    exit;
}

foreach ($data as $item) {
    $product_name = mysqli_real_escape_string($conn, $item['product']);
    $quantity = (int) $item['qty'];
    $price = (float) $item['price'];

    $total = $price * $quantity;

    $sql = "INSERT INTO sales (product_name, quantity, price, total) VALUES ('{$product_name}', {$quantity}, {$price}, {$total})";

    if (!mysqli_query($conn, $sql)) {
        http_response_code(500);
        echo 'Database error: ' . mysqli_error($conn);
        exit;
    }
}

echo 'Success';

?>