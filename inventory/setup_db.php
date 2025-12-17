<?php
include 'connect.php';

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS inventory (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    quantity INT(6) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'inventory' created successfully or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
