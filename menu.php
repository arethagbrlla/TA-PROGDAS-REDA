<!-- File: menu.php -->
<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Menu.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$result = $db->query("SELECT * FROM menu WHERE status = 'tersedia'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Warung Bakso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <h2 class="mb-4">Menu Bakso</h2>
        <div class="row">
            <?php while ($menu = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($menu['nama']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($menu['deskripsi']); ?></p>
                            <p class="card-text"><strong>Harga: Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></strong></p>
                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="menu_id" value="<?php echo $menu['id']; ?>">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="quantity" value="1" min="1">
                                    <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

