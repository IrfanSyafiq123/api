<?php

include '../config/cors.php';
include '../config/database.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id = $data['id'];
$status = $data['status'];

$stmt = $conn->prepare(
    "UPDATE orders
     SET status = ?
     WHERE id = ?"
);

$stmt->bind_param(
    "si",
    $status,
    $id
);

$success = $stmt->execute();

echo json_encode([
    "success" => $success
]);