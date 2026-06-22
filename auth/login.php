<?php

include '../config/cors.php';
include '../config/database.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$email = $data['email'] ?? '';
$password = md5(
    $data['password'] ?? ''
);

$stmt = $conn->prepare(
    "SELECT *
    FROM users
    WHERE email=? AND password=?"
);

$stmt->bind_param(
    "ss",
    $email,
    $password
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    echo json_encode([
        "success" => true,
        "user" => [
            "id" => $user['id'],
            "name" => $user['name'],
            "email" => $user['email'],
            "role" => $user['role']
        ]
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Email atau password salah"
    ]);
}