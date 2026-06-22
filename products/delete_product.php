<?php

include '../config/cors.php';
include '../config/database.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id = $data['id'];

$stmt = $conn->prepare(
    "DELETE FROM products
     WHERE id=?"
);

$stmt->bind_param(
    "i",
    $id
);

echo json_encode([
    "success" => $stmt->execute()
]);