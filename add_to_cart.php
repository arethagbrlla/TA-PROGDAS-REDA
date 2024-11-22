<?php
// File: add_to_cart.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_id = $_POST['menu_id'];
    $quantity = (int)$_POST['quantity'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$menu_id])) {
        $_SESSION['cart'][$menu_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$menu_id] = [
            'quantity' => $quantity
        ];
    }
    
    header("Location: cart.php");
    exit();
}
