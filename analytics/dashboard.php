<?php

include '../config/cors.php';
include '../config/database.php';

$totalProducts =
$conn->query(
"SELECT COUNT(*) total
 FROM products"
)->fetch_assoc()['total'];

$totalUsers =
$conn->query(
"SELECT COUNT(*) total
 FROM users
 WHERE role='user'"
)->fetch_assoc()['total'];

$totalOrders =
$conn->query(
"SELECT COUNT(*) total
 FROM orders"
)->fetch_assoc()['total'];

$totalRevenue =
$conn->query(
"
SELECT
IFNULL(SUM(total),0) revenue
FROM orders
WHERE status IN
('Processing','Completed')
"
)->fetch_assoc()['revenue'];

$todayRevenue =
$conn->query(
"
SELECT
IFNULL(SUM(total),0) revenue
FROM orders
WHERE DATE(created_at)=CURDATE()
"
)->fetch_assoc()['revenue'];

$pending =
$conn->query(
"
SELECT COUNT(*) total
FROM orders
WHERE status='Pending'
"
)->fetch_assoc()['total'];

$processing =
$conn->query(
"
SELECT COUNT(*) total
FROM orders
WHERE status='Processing'
"
)->fetch_assoc()['total'];

$completed =
$conn->query(
"
SELECT COUNT(*) total
FROM orders
WHERE status='Completed'
"
)->fetch_assoc()['total'];

$cancelled =
$conn->query(
"
SELECT COUNT(*) total
FROM orders
WHERE status='Cancelled'
"
)->fetch_assoc()['total'];

echo json_encode([
    "success" => true,
    "data" => [
        "total_products" => $totalProducts,
        "total_users" => $totalUsers,
        "total_orders" => $totalOrders,
        "total_revenue" => $totalRevenue,
        "today_revenue" => $todayRevenue,
        "pending_orders" => $pending,
        "processing_orders" => $processing,
        "completed_orders" => $completed,
        "cancelled_orders" => $cancelled
    ]
]);