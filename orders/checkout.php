<?php

include '../config/cors.php';
include '../config/database.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$user_id = $data['user_id'];
$total = $data['total'];
$payment_method = $data['payment_method'];

$stmt = $conn->prepare(
    "INSERT INTO orders
    (
      user_id,
      total,
      payment_method
    )
    VALUES
    (?,?,?)"
);

$stmt->bind_param(
    "ids",
    $user_id,
    $total,
    $payment_method
);

$stmt->execute();

$order_id = $conn->insert_id;

$cart = $conn->query(
"
SELECT *
FROM cart
WHERE user_id=$user_id
"
);

while($item = $cart->fetch_assoc()){

    $product = $conn->query(
    "
    SELECT *
    FROM products
    WHERE id=".$item['product_id']
    )->fetch_assoc();

    $insert = $conn->prepare(
        "INSERT INTO order_items
        (
          order_id,
          product_id,
          quantity,
          price
        )
        VALUES
        (?,?,?,?)"
    );

    $insert->bind_param(
        "iiid",
        $order_id,
        $item['product_id'],
        $item['quantity'],
        $product['price']
    );

    $insert->execute();

    $updateStock = $conn->prepare(
        "UPDATE products
        SET stock = stock - ?
        WHERE id=?"
    );

    $updateStock->bind_param(
        "ii",
        $item['quantity'],
        $item['product_id']
    );

    $updateStock->execute();
}

$conn->query(
"DELETE FROM cart
 WHERE user_id=$user_id"
);

echo json_encode([
    "success" => true,
    "order_id" => $order_id
]);