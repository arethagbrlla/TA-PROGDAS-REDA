<!-- File: admin/index.php -->
<?php
session_start();
require_once '../classes/Database.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$db = new Database();
$pending_orders = $db->query("SELECT * FROM orders WHERE status = 'pending' ORDER BY waktu_pesan ASC");
$processing_orders = $db->query("SELECT * FROM orders WHERE status = 'processing' ORDER BY waktu_pesan ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Warung Bakso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pesanan Menunggu</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($pending_orders->num_rows > 0): ?>
                            <div class="list-group">
                                <?php while ($order = $pending_orders->fetch_assoc()): ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Order #<?php echo $order['id']; ?></h6>
                                                <small>Total: Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></small>
                                            </div>
                                            <form action="process_order_status.php" method="POST" class="d-inline">
                                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="btn btn-primary btn-sm">Proses</button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">Tidak ada pesanan menunggu</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pesanan Diproses</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($processing_orders->num_rows > 0): ?>
                            <div class="list-group">
                                <?php while ($order = $processing_orders->fetch_assoc()): ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Order #<?php echo $order['id']; ?></h6>
                                                <small>Total: Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></small>
                                            </div>
                                            <form action="process_order_status.php" method="POST" class="d-inline">
                                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">Tidak ada pesanan diproses</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
