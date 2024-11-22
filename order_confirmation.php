<?php
// File: order_confirmation.php
session_start();
require_once 'classes/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['id'];
$db = new Database();

$order_query = $db->query("SELECT * FROM orders WHERE id = " . $order_id);
$order = $order_query->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Warung Bakso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="card-title mb-4">Pesanan Berhasil!</h2>
                        <div class="alert alert-success">
                            <h4>Nomor Pesanan: #<?php echo $order_id; ?></h4>
                            <p>Total Pembayaran: Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></p>
                        </div>
                        <p>Pesanan Anda sedang diproses. Silakan tunggu nomor antrian Anda dipanggil.</p>
                        <div class="mt-4">
                            <a href="menu.php" class="btn btn-primary">Kembali ke Menu</a>
                            <a href="order_status.php?id=<?php echo $order_id; ?>" class="btn btn-info">Cek Status Pesanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>