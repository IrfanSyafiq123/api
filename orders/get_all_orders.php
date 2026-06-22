<?php

include '../config/cors.php';
include '../config/database.php';

$sql = "
SELECT
orders.*,
users.name

FROM orders

JOIN users
ON orders.user_id = users.id

ORDER BY orders.id DESC
";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);