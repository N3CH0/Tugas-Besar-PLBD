<?php
// Admin sidebar template
$currentPage = $_GET['page'] ?? 'dashboard';
$userNama = $_SESSION['user_nama'] ?? 'Admin';
$userPeran = $_SESSION['user_peran'] ?? '';
$initial = strtoupper(substr($userNama, 0, 1));
?>
<aside class="sidebar">
    <div class="sidebar-logo">
        <i class="fa-solid fa-fish"></i>
        <span>Toko Ikan Hias</span>
    </div>

    <div class="sidebar-label">Menu Utama</div>
    <a href="index.php?page=dashboard" class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">
        <i class="fa-solid fa-chart-pie"></i> Dashboard
    </a>
    <a href="index.php?page=barang" class="<?= $currentPage === 'barang' ? 'active' : '' ?>">
        <i class="fa-solid fa-box"></i> Barang
    </a>
    <a href="index.php?page=kategori" class="<?= $currentPage === 'kategori' ? 'active' : '' ?>">
        <i class="fa-solid fa-layer-group"></i> Kategori
    </a>
    <a href="index.php?page=penjualan" class="<?= $currentPage === 'penjualan' ? 'active' : '' ?>">
        <i class="fa-solid fa-cash-register"></i> Penjualan
    </a>

    <?php if ($userPeran === 'pemilik'): ?>
    <div class="sidebar-label">Kelola Akun</div>
    <a href="index.php?page=karyawan" class="<?= $currentPage === 'karyawan' ? 'active' : '' ?>">
        <i class="fa-solid fa-users"></i> Karyawan
    </a>
    <?php endif; ?>

    <div class="sidebar-label">Lainnya</div>
    <a href="index.php">
        <i class="fa-solid fa-store"></i> Lihat Toko
    </a>
    <a href="index.php?page=logout" onclick="return confirm('Yakin ingin logout?')">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar"><?= $initial ?></div>
            <div>
                <div style="font-weight: 600; font-size: 13px;"><?= htmlspecialchars($userNama) ?></div>
                <div style="font-size: 11px; color: rgba(255,255,255,.5); text-transform: capitalize;"><?= $userPeran ?></div>
            </div>
        </div>
    </div>
</aside>

