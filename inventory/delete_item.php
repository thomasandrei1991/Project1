<?php
header('Content-Type: application/json');
include 'connect.php';

$id = $_POST['id'] ?? '';

if (empty($id) || !is_numeric($id)) {
    echo json_encode(array("success" => false, "message" => "Valid ID is required."));
    exit;
}

$stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(array("success" => true, "message" => "Item deleted successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Item not found."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Error deleting item: " . $stmt->error));
}

$stmt->close();
$conn->close();
?>
