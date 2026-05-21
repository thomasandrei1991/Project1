<?php
    require_once __DIR__ . '/../config/database.php';
    /** @var mysqli $conn */

    if (isset($_POST['add_product'])) {
        $product_name = trim($_POST['product_name']);
        $category = trim($_POST['category']);
        $price = (float)$_POST['price'];
        $stocks = (int)$_POST['stocks'];
        $barcode = trim($_POST['barcode']);
        $imageName = null;

        // Image Upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0 && !empty($_FILES['image']['name'])) {
            
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($ext, $allowed)) {
                $imageName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
                $uploadDir = __DIR__ . '/../assets/images/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $uploadPath = $uploadDir . $imageName;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    die("Failed to upload image.");
                }
            } else {
                die("Invalid image type. Only JPG, PNG, GIF, and WEBP are allowed.");
            }
        }

        // Insert to Database (Prepared Statement - Safe from SQL Injection)
        $sql = "INSERT INTO products (product_name, category, price, barcode, stocks, image) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sssdss', 
                $product_name, 
                $category, 
                $price, 
                $stocks, 
                $barcode, 
                $imageName
            );

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: ../inventory.php?success=added");
                exit;
            } else {
                die("Insert failed: " . mysqli_error($conn));
            }
        } else {
            die("Prepare failed: " . mysqli_error($conn));
        }
    }
?>