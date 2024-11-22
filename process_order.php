<?php
// File: process_order.php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Order.php';
require_once 'classes/OrderQueue.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: menu.php");
    exit();
}

$db = new Database();
$order = new Order($_SESSION['user_id']);

// Insert order into database
$sql = "INSERT INTO orders (user_id, total_harga, status) VALUES (?, ?, 'pending')";
$stmt = $db->prepare($sql);
$stmt->bind_param("id", $_SESSION['user_id'], $_POST['total']);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert order items
foreach ($_SESSION['cart'] as $menu_id => $item) {
    $menu_query = $db->query("SELECT * FROM menu WHERE id = " . $menu_id);
    $menu = $menu_query->fetch_assoc();
    
    $sql = "INSERT INTO order_items (order_id, menu_id, quantity, harga_satuan) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iiid", $order_id, $menu_id, $item['quantity'], $menu['harga']);
    $stmt->execute();
}

// Add to queue
$orderQueue = new OrderQueue();
$orderQueue->enqueue($order_id);

// Clear cart
unset($_SESSION['cart']);

// Redirect to order confirmation
$_SESSION['success'] = "Pesanan berhasil dibuat!";
header("Location: order_confirmation.php?id=" . $order_id);
exit();
