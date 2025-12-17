<?php
header('Content-Type: application/json');
include 'connect.php';

$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';

if (empty($id) || empty($name) || empty($quantity) || empty($price)) {
    echo json_encode(array("success" => false, "message" => "ID, name, quantity, and price are required."));
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

$stmt = $conn->prepare("UPDATE inventory SET name = ?, quantity = ?, price = ?, description = ? WHERE id = ?");
$stmt->bind_param("sidsi", $name, $quantity, $price, $description, $id);

if ($stmt->execute()) {
    echo json_encode(array("success" => true, "message" => "Item updated successfully."));
} else {
    echo json_encode(array("success" => false, "message" => "Error updating item: " . $stmt->error));
}

$stmt->close();
$conn->close();
?>
