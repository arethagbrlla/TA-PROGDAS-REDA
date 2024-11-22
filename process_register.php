<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data input dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validasi password dan konfirmasi password
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak cocok.";
        header("Location: register.php");
        exit();
    }

    // Buat objek User
    $user = new User($username, $password);

    // Inisialisasi koneksi database
    $db = new Database();

    // Siapkan SQL untuk menyimpan data user
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);

    if ($stmt) {
        // Gunakan getter untuk mengakses nilai properti
        $stmt->bind_param("sss", $user->getUsername(), $user->getPassword(), $user->getRole());

        // Eksekusi statement
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: login.php");
        } else {
            $_SESSION['error'] = "Gagal melakukan registrasi: " . $stmt->error;
            header("Location: register.php");
        }
    } else {
        $_SESSION['error'] = "Terjadi kesalahan pada server.";
        header("Location: register.php");
    }
    exit();
} else {
    header("Location: register.php");
    exit();
}
?>
