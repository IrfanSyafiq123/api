<?php

include '../config/cors.php';
include '../config/database.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$name = $data['name'] ?? '';
$storage = $data['storage'] ?? '';
$description = $data['description'] ?? '';
$price = $data['price'] ?? 0;
$stock = $data['stock'] ?? 0;
$image = $data['image'] ?? '';

$stmt = $conn->prepare(
    "INSERT INTO products
    (
      name,
      storage,
      description,
      price,
      stock,
      image
    )
    VALUES
    (?,?,?,?,?,?)"
);

$stmt->bind_param(
    "sssdis",
    $name,
    $storage,
    $description,
    $price,
    $stock,
    $image
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Produk berhasil ditambahkan"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Gagal menambahkan produk"
    ]);
}