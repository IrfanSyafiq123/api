<?php

include '../config/cors.php';
include '../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (
    empty($name) ||
    empty($email) ||
    empty($password)
) {
    echo json_encode([
        "success" => false,
        "message" => "Semua field wajib diisi"
    ]);
    exit;
}

$check = $conn->prepare(
    "SELECT id FROM users WHERE email=?"
);

$check->bind_param("s", $email);
$check->execute();

$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Email sudah terdaftar"
    ]);
    exit;
}

$password = md5($password);

$stmt = $conn->prepare(
    "INSERT INTO users
    (name,email,password,role)
    VALUES
    (?, ?, ?, 'user')"
);

$stmt->bind_param(
    "sss",
    $name,
    $email,
    $password
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Registrasi berhasil"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Registrasi gagal"
    ]);
}