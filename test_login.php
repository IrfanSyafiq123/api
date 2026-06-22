<?php

$url = "http://localhost/api_iphone/auth/login.php";

$data = [
    "email" => "admin@gmail.com",
    "password" => "admin123"
];

$options = [
    'http' => [
        'header'  => "Content-type: application/json",
        'method'  => 'POST',
        'content' => json_encode($data),
    ]
];

$context = stream_context_create($options);

$result = file_get_contents(
    $url,
    false,
    $context
);

echo $result;