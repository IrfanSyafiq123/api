<?php

header("Content-Type: application/json");

$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database,
    $port
);

if ($conn->connect_error) {
    die(
        json_encode([
            "success" => false,
            "message" => "Database connection failed",
            "error" => $conn->connect_error
        ])
    );
}

$conn->set_charset("utf8");
?>
