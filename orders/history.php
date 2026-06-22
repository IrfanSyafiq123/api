<?php

include '../config/cors.php';
include '../config/database.php';

$user_id = $_GET['user_id'];

$result = $conn->query(
"
SELECT *
FROM orders
WHERE user_id=$user_id
ORDER BY id DESC
"
);

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);