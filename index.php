<?php
session_start();
require_once 'classes/Database.php';

$db = new Database();
$featured_menu = $db->query("SELECT * FROM menu WHERE status = 'tersedia' LIMIT 3");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Bakso - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; }
        .hero
{
    background-size: cover;
            color: rgb(255, 255, 255);
            padding: 1000px 20px;
            text-align: center;
}
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .nav { 
            background: #5d5e5f; 
            color: rgb(241, 241, 241); 
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
        }
        .nav a { color: rgb(255, 255, 255); text-decoration: none; margin: 0 10px; }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 40px;
        }
        .menu-item {
            border: 1px solid #000000;
            padding: 50px;
            text-align: center;
            border-radius: 8px;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; 
    ?>
 <style>
        body {
 background: linear-gradient(rgba(19, 11, 12, 0.5), rgba(253, 182, 124, 0.342)), 
            url('https://cdn0-production-images-kly.akamaized.net/8M19AA3TzFcADp6RjFg4kKcTVa4=/1280x720/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/4056078/original/079437400_1655454761-beef-ball-fried-dark-wooden-surface.jpg');opacity: 0.9;
            background-repeat: no-repeat;
            background-size: cover;
}
    </style>
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4">Selamat Datang di Warung Bakso Dafel</h1>
            <p class="lead">Berdiri sejak 1984</p>
            <a href="menu.php" class="btn btn-outline-dark btn-lg">Lihat Menu</a>

        </div>
    </div>

    <div class="container">
        <h2 class="text-center mb-4">Menu Favorit</h2>
        <div class="row">
            <?php while ($menu = $featured_menu->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                         <div class="card h-100"> 
                         <img class="card-img-top" src="https://cdn0-production-images-kly.akamaized.net/o8vUi0at1gpExFL7LW8QyO7r9Co=/1280x720/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/2763419/original/071857300_1553761217-shutterstock_1148354906.jpg" alt="Card image cap">
                <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($menu['nama']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($menu['deskripsi']); ?></p>
                            <p class="card-text"><strong>Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></strong></p>
                            <a href="menu.php" class="btn btn-secondary">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="row mt-5">
            <div class="col-md-4 text-center">
                <i class="bi bi-clock display-4"></i>
                <h3>Cepat Saji</h3>
                <p>Pesanan Anda akan siap dalam waktu singkat</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="bi bi-heart display-4"></i>
                <h3>Kualitas Terbaik</h3>
                <p>Dibuat dengan bahan berkualitas dan resep spesial</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="bi bi-cash display-4"></i>
                <h3>Harga Terjangkau</h3>
                <p>Nikmati makanan lezat dengan harga bersahabat</p>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h5>Warung Bakso Dafel</h5>
                    <p>Menyajikan bakso berkualitas sejak 1984</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Hubungi Kami</h5>
                    <p>
                        Email: bakso dafel@gmail.com<br>
                        Telepon: +62 822-2757-5076
                    </p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; 2024 Warung Bakso. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>