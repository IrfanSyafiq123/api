<?php

include '../config/cors.php';
include '../config/database.php';

$user_id = $_GET['user_id'];

$sql = "
SELECT
cart.id,
products.name,
products.price,
products.image,
cart.quantity

FROM cart

JOIN products
ON cart.product_id = products.id

WHERE cart.user_id = $user_id
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