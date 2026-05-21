<?php
    require_once __DIR__ . '/../config/database.php';
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Database delete failed: " . mysqli_error($conn));
    }
    header("Location: ../inventory.php");
    exit;

?>

