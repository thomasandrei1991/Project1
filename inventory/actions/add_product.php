<?php

    require_once __DIR__ . '/../config/database.php';

    if (isset($_POST['add_product'])) {

        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $stocks = $_POST['stocks'];

        $sql = "INSERT INTO products(product_name, price, stocks)
                VALUES('$product_name', '$price', '$stocks')";

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Database insert failed: " . mysqli_error($conn));
        }

        header("Location: ../inventory.php");
        exit;

    }

?>