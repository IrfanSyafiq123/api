<?php

include '../config/cors.php';
include '../config/database.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id = $data['id'];
$quantity = $data['quantity'];

$stmt = $conn->prepare(
    "UPDATE cart SET quantity=? WHERE id=?"
);

$stmt->bind_param(
    "ii",
    $quantity,
    $id
);

$success = $stmt->execute();

echo json_encode([
    "success" => $success
]);