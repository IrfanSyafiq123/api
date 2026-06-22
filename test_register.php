<?php

$url = "http://localhost/api_iphone/auth/register.php";

$data = [
    "name" => "Aditya",
    "email" => "aditya@gmail.com",
    "password" => "123456"
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