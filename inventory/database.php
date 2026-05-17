<?php
header('Content-Type: application/json');
include 'connect.php';

$name = $_POST['name'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';

if (empty($name) || empty($quantity) || empty($price)) {
    echo json_encode(array("success" => false, "message" => "Name, quantity, and price are required."));
    exit;
}

if (!is_numeric($quantity) || $quantity < 0) {
    echo json_encode(array("success" => false, "message" => "Quantity must be a non-negative number."));
    exit;
}

if (!is_numeric($price) || $price < 0) {
    echo json_encode(array("success" => false, "message" => "Price must be a non-negative number."));
    exit;
}

$stmt = $conn->prepare("INSERT INTO inventory (name, quantity, price, description) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sids", $name, $quantity, $price, $description);

if ($stmt->execute()) {
    echo json_encode(array("success" => true, "message" => "Item added successfully."));
} else {
    echo json_encode(array("success" => false, "message" => "Error adding item: " . $stmt->error));
}

$stmt->close();
$conn->close();
?>
