<?php
// File: admin/process_order_status.php
session_start();
require_once '../classes/Database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    
    $db = new Database();
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    
    header("Location: index.php");
    exit();
}