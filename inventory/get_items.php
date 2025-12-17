<?php
header('Content-Type: application/json');
include 'connect.php';

$sql = "SELECT id, name, quantity, price, description FROM inventory ORDER BY id DESC";
$result = $conn->query($sql);

$items = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    echo json_encode(array("success" => true, "items" => $items));
} else {
    echo json_encode(array("success" => true, "items" => array(), "message" => "No items found"));
}

$conn->close();
?>
