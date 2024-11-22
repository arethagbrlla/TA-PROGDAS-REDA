// File: functions.php
<?php
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function getStatusBadge($status) {
    switch($status) {
        case 'pending':
            return '<span class="badge bg-warning text-dark">Menunggu</span>';
        case 'processing':
            return '<span class="badge bg-primary">Diproses</span>';
        case 'completed':
            return '<span class="badge bg-success">Selesai</span>';
        case 'cancelled':
            return '<span class="badge bg-danger">Dibatalkan</span>';
        default:
            return '<span class="badge bg-secondary">Unknown</span>';
    }
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
