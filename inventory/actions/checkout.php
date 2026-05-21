<?php
    session_start();
    require_once __DIR__ . '/../config/database.php';

    /** @var mysqli $conn */

    header('Content-Type: application/json');
    $request = json_decode(file_get_contents('php://input'), true);
    $data = $request['cart'];
    $total = $request['total'];
    $payment = $request['payment'];
    $change = $request['change'];

    if (!is_array($data) || empty($data)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid request payload']);
        exit;
    }

    // === 1. Stock Validation ===
    foreach ($data as $item) {
        if (!isset($item['product'], $item['qty'], $item['price'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
            exit;
        }

        $product_name = trim($item['product']);
        $quantity = (int)$item['qty'];

        $stmt = mysqli_prepare($conn, "SELECT stocks FROM products WHERE product_name = ?");
        mysqli_stmt_bind_param($stmt, 's', $product_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $current_stock);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($current_stock === null) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Product not found: ' . $product_name]);
            exit;
        }

        if ($current_stock < $quantity) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' =>
                "Insufficient stock for {$product_name}"
            ]);
            exit;
        }
    }

    // === 2. Process Sale & Update Stock ===
    mysqli_begin_transaction($conn);   // ← Important: Para consistent ang data

    try {
        foreach ($data as $item) {
            $product_name = trim($item['product']);
            $quantity     = (int)$item['qty'];
            $price        = (float)$item['price'];
            $total        = $price * $quantity;

            // Insert into sales
            $stmt = mysqli_prepare($conn, 
                "INSERT INTO sales (product_name, quantity, price, total, created_at) 
                VALUES (?, ?, ?, ?, NOW())"
            );
            mysqli_stmt_bind_param($stmt, 'sidd', $product_name, $quantity, $price, $total);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Update stock
            $stmt = mysqli_prepare($conn, 
                "UPDATE products SET stocks = stocks - ? WHERE product_name = ?"
            );
            mysqli_stmt_bind_param($stmt, 'is', $quantity, $product_name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        mysqli_commit($conn);
        $_SESSION['receipt'] = ['cart' => $data, 'total' => $total, 'payment' => $payment, 'change' => $change];
        echo json_encode([
            'status' => 'success',
            'message' => 'Sale completed successfully',
            'redirect' => 'receipt.php'
        ]);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
    }
?>