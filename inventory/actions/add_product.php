<?php

    require_once __DIR__ . '/../config/database.php';

    if (isset($_POST['add_product'])) {

        $product_name = $_POST['product_name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $stocks = $_POST['stocks'];
        $imageName = basename($_FILES['image']['name']);
        $tempName = $_FILES['image']['tmp_name'];
        $folder = "../assets/images/" . $imageName;
        $barcode = $_POST['barcode'];

        move_uploaded_file(
            $tempName,
            $folder
        );

        $sql = "INSERT INTO products(product_name, category, price, barcode,  stocks, image) VALUES('$product_name', '$category', '$price', '$barcode', '$stocks', '$imageName')";
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            die("Database insert failed: " . mysqli_error($conn));
        }

        header("Location: ../inventory.php");
        exit;

    }

?>