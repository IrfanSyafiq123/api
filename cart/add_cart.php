<?php

include '../config/cors.php';
include '../config/database.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$user_id = $data['user_id'];
$product_id = $data['product_id'];

$check = $conn->prepare(
    "SELECT * FROM cart
     WHERE user_id=? AND product_id=?"
);

$check->bind_param(
    "ii",
    $user_id,
    $product_id
);

$check->execute();

$result = $check->get_result();

if($result->num_rows > 0){

    $conn->query(
        "UPDATE cart
         SET quantity = quantity + 1
         WHERE user_id=$user_id
         AND product_id=$product_id"
    );

}else{

    $stmt = $conn->prepare(
        "INSERT INTO cart
        (user_id,product_id,quantity)
        VALUES(?,?,1)"
    );

    $stmt->bind_param(
        "ii",
        $user_id,
        $product_id
    );

    $stmt->execute();
}

echo json_encode([
    "success" => true
]);