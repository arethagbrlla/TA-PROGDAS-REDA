<?php
// File: update_cart.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_id = $_POST['menu_id'];
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity > 0) {
        $_SESSION['cart'][$menu_id]['quantity'] = $quantity;
    }
    
    header("Location: cart.php");
    exit();
}
