<?php

include '../config/cors.php';

if (!isset($_FILES['image'])) {

    echo json_encode([
        "success" => false
    ]);

    exit;
}

$file = $_FILES['image'];

$fileName =
time() . "_" . basename($file['name']);

$target =
"../uploads/" . $fileName;

if (
    move_uploaded_file(
        $file['tmp_name'],
        $target
    )
) {

    echo json_encode([
        "success" => true,
        "image" => $fileName
    ]);

} else {

    echo json_encode([
        "success" => false
    ]);
}