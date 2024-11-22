<!-- File: order_status.php -->
<?php
session_start();
require_once 'classes/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$order_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($order_id) {
    $order_query = $db->query("SELECT o.*, u.username 
                              FROM orders o 
                              JOIN users u ON o.user_id = u.id 
                              WHERE o.id = " . $order_id . " AND o.user_id = " . $_SESSION['user_id']);
    $order = $order_query->fetch_assoc();

    $items_query = $db->query("SELECT oi.*, m.nama 
                              FROM order_items oi 
                              JOIN menu m ON oi.menu_id = m.id 
                              WHERE oi.order_id = " . $order_id);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - Warung Bakso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <?php if ($order): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Status Pesanan #<?php echo $order_id; ?></h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Detail Pesanan</h5>
                            <p>Waktu Pesan: <?php echo date('d/m/Y H:i', strtotime($order['waktu_pesan'])); ?></p>
                            <p>Status: 
                                <span class="badge <?php
                                    switch($order['status']) {
                                        case 'pending': echo 'bg-warning'; break;
                                        case 'processing': echo 'bg-primary'; break;
                                        case 'completed': echo 'bg-success'; break;
                                        case 'cancelled': echo 'bg-danger'; break;
                                    }
                                ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </p>
                            <p>Total: Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Detail Menu</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($item = $items_query->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($item['nama']); ?></td>
                                                <td><?php echo $item['quantity']; ?></td>
                                                <td>Rp <?php echo number_format($item['harga_satuan'], 0, ',', '.'); ?></td>
                                                <td>Rp <?php echo number_format($item['harga_satuan'] * $item['quantity'], 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="progress mb-4">
                        <?php
                        $progress = 0;
                        switch($order['status']) {
                            case 'pending': $progress = 25; break;
                            case 'processing': $progress = 50; break;
                            case 'completed': $progress = 100; break;
                        }
                        ?>
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $progress; ?>%" 
                             aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <?php if ($order['status'] === 'completed'): ?>
                            <div class="alert alert-success" role="alert">
                                Pesanan Anda telah selesai! Silakan ambil pesanan Anda.
                            </div>
                        <?php elseif ($order['status'] === 'cancelled'): ?>
                            <div class="alert alert-danger" role="alert">
                                Pesanan telah dibatalkan.
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                Pesanan Anda sedang diproses. Mohon tunggu sebentar.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                Pesanan tidak ditemukan atau Anda tidak memiliki akses ke pesanan ini.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
