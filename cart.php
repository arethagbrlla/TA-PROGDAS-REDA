<!-- File: cart.php -->
<?php
session_start();
require_once 'classes/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$db = new Database();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Warung Bakso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <h2 class="mb-4">Keranjang Belanja</h2>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <div class="alert alert-info">Keranjang belanja kosong</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $menu_id => $item): 
                            $menu_query = $db->query("SELECT * FROM menu WHERE id = " . $menu_id);
                            $menu = $menu_query->fetch_assoc();
                            $subtotal = $menu['harga'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($menu['nama']); ?></td>
                                <td>Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <form action="update_cart.php" method="POST" class="d-inline">
                                        <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control" style="width: 80px;" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                <td>
                                    <form action="remove_from_cart.php" method="POST" class="d-inline">
                                        <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="text-end mt-3">
                <a href="menu.php" class="btn btn-secondary">Lanjut Belanja</a>
                <a href="checkout.php" class="btn btn-primary">Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
