<?php
    require_once __DIR__ . '/../config/database.php';
    $conn = $GLOBALS['conn'];

    if (isset($_POST['update_product'])) {
        $id           = (int)$_POST['id'];
        $product_name = trim($_POST['product_name']);
        $category     = trim($_POST['category']);
        $barcode      = trim($_POST['barcode']);
        $price        = (float)$_POST['price'];
        $stocks       = (int)$_POST['stocks'];

        // Get current image
        $imageName = null;
        $stmt = mysqli_prepare($conn, "SELECT image FROM products WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $imageName);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // New Image Upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0 && !empty($_FILES['image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif','webp'];

            if (in_array($ext, $allowed)) {
                $newName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
                
                // Correct Upload Path (from actions/ folder)
                $uploadDir = __DIR__ . '/../../assets/images/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $uploadPath = $uploadDir . $newName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    // Delete old image
                    if ($imageName && file_exists($uploadDir . $imageName)) {
                        unlink($uploadDir . $imageName);
                    }
                    $imageName = $newName;
                }
            }
        }

        // Update Database
        $sql = "UPDATE products SET product_name=?, category=?, barcode=?, price=?, stocks=?, image=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssddsi', $product_name, $category, $barcode, $price, $stocks, $imageName, $id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: ../edit_product.php?id=$id&success=1");
            exit;
        } else {
            echo "Update Error: " . mysqli_error($conn);
        }
    }
?>