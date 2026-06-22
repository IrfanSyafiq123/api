<?php

$url =
"http://localhost/api_iphone/products/add_product.php";

$data = [
    "name" => "iPhone 17 Ultra",
    "storage" => "512GB",
    "description" => "Titanium Edition",
    "price" => 29999000,
    "stock" => 5,
    "image" => "iphone17ultra.png"
];

$options = [
    'http' => [
        'header' => "Content-Type: application/json",
        'method' => 'POST',
        'content' => json_encode($data)
    ]
];

$context = stream_context_create($options);

echo file_get_contents(
    $url,
    false,
    $context
);