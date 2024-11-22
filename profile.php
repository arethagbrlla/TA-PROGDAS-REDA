// File: profile.php
<?php
session_start();
require_once 'classes/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$user_query = $db->query("SELECT * FROM users WHERE id = " . $_SESSION['user_id']);
$user = $user_query->fetch_assoc();

// Ambil riwayat pesanan
$orders_query = $db->query("
    SELECT orders.*, COUNT(order_items.id) as total_items 
    FROM orders 
    LEFT JOIN order_items ON orders.id = order_items.order_id 
    WHERE user_id = " . $_SESSION['user_id'] . "
    GROUP BY orders.id 
    ORDER BY orders.waktu_pesan DESC
");
 function formatRupiah($angka) 
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
function getStatusBadge($status) {
    $badgeClass = '';

    // Menentukan warna badge berdasarkan status
    switch ($status) {
        case 'selesai':
            $badgeClass = 'badge bg-success'; // Hijau untuk tersedia
            break;
        case 'dibatalkan':
            $badgeClass = 'badge bg-danger'; // Merah untuk habis
            break;
        default:
        $badgeClass = 'badge bg-success'; // Abu-abu untuk status lain
        break;
    }

    // Menghasilkan elemen HTML badge
    return '<span class="' . $badgeClass . '">' . htmlspecialchars($status) . '</span>';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Warung Bakso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profil Saya</h5>
                    </div>
                    <div class="card-body">
                        <form action="update_profile.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Profil</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Riwayat Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($orders_query->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Total Item</th>
                                            <th>Total Harga</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($order = $orders_query->fetch_assoc()): ?>
                                            <tr>
                                                <td>#<?php echo $order['id']; ?></td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($order['waktu_pesan'])); ?></td>
                                                <td><?php echo $order['total_items']; ?> item</td>
                                                <td><?php echo formatRupiah($order['total_harga']); ?></td>
                                                <td><?php echo getStatusBadge($order['status']); ?></td>
                                                <td>
                                                    <a href="order_status.php?id=<?php echo $order['id']; ?>" 
                                                       class="btn btn-sm btn-info">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Belum ada riwayat pesanan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
