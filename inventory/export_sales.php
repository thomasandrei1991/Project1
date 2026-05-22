<?php

require_once __DIR__ . "/config/database.php";

/** @var mysqli $conn */



// FILE NAME
$filename =
"sales_report_" .
date("Y-m-d") .
".csv";

// HEADERS
header("Content-Type: text/csv");

header(
"Content-Disposition: attachment; filename=$filename"
);

// OPEN OUTPUT
$output =
fopen("php://output", "w");

// COLUMN HEADERS
fputcsv($output, [

    'Product Name',
    'Quantity',
    'Price',
    'Total',
    'Date'

]);

// GET SALES
$sql = "
SELECT *
FROM sales
ORDER BY created_at DESC
";

$result =
mysqli_query($conn, $sql);

// OUTPUT ROWS
while($row = mysqli_fetch_assoc($result)){

    fputcsv($output, [

        $row['product_name'],
        $row['quantity'],
        $row['price'],
        $row['total'],
        $row['created_at']

    ]);

}

fclose($output);

exit;

?>