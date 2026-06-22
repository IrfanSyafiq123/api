<?php

include '../config/cors.php';
include '../config/database.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id = $data['id'];

$name = $data['name'];
$storage = $data['storage'];
$description = $data['description'];
$price = $data['price'];
$stock = $data['stock'];
$image = $data['image'];

$stmt = $conn->prepare(
    "UPDATE products SET
        name=?,
        storage=?,
        description=?,
        price=?,
        stock=?,
        image=?
    WHERE id=?"
);

$stmt->bind_param(
    "sssdisi",
    $name,
    $storage,
    $description,
    $price,
    $stock,
    $image,
    $id
);

echo json_encode([
    "success" => $stmt->execute()
]);