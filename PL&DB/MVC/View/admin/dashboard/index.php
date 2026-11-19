<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Toko Ikan Hias</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="View/style.css">
</head>
<body>
<div class="admin-layout">
    <?php require __DIR__ . '/../../templates/sidebar.php'; ?>

    <main class="admin-main">
        <div class="page-header">
            <div>
                <h1>Dashboard</h1>
                <p>Selamat datang, <?= htmlspecialchars($_SESSION['user_nama']) ?>!</p>
            </div>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-box"></i></div>
                <div>
                    <div class="stat-num"><?= $totalBarang ?></div>
                    <div class="stat-label">Total Barang</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fa-solid fa-cash-register"></i></div>
                <div>
                    <div class="stat-num"><?= $jumlahTransaksi ?></div>
                    <div class="stat-label">Total Transaksi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon amber"><i class="fa-solid fa-coins"></i></div>
                <div>
                    <div class="stat-num">Rp <?= number_format($totalPenjualan, 0, ',', '.') ?></div>
                    <div class="stat-label">Total Penjualan</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div>
                    <div class="stat-num"><?= count($stokMenipis) ?></div>
                    <div class="stat-label">Stok Menipis</div>
                </div>
            </div>
        </div>

        <!-- STOK MENIPIS -->
        <?php if (!empty($stokMenipis)): ?>
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header">
                <h2><i class="fa-solid fa-triangle-exclamation" style="color: var(--danger);"></i> Peringatan Stok Menipis</h2>
            </div>
            <div class="table-container">
                <table>
                    <thead><tr><th>Barang</th><th>Kategori</th><th>Stok</th><th>Minimum</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php foreach ($stokMenipis as $s): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($s['nama_barang']) ?></strong></td>
                        <td><span class="badge badge-teal"><?= htmlspecialchars($s['nama_kategori']) ?></span></td>
                        <td><?= $s['stok'] ?></td>
                        <td><?= $s['stok_minimum'] ?></td>
                        <td><span class="badge badge-red">MENIPIS</span></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- PENJUALAN TERBARU -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fa-solid fa-clock-rotate-left"></i> Penjualan Terbaru</h2>
                <a href="index.php?page=penjualan" class="btn btn-primary btn-sm">Lihat Semua</a>
            </div>
            <div class="table-container">
                <table>
                    <thead><tr><th class="number-col">ID</th><th>Tanggal</th><th>Pencatat</th><th>Metode</th><th>Total</th></tr></thead>
                    <tbody>
                    <?php if (empty($penjualanTerbaru)): ?>
                        <tr><td colspan="5"><div class="empty-state"><p>Belum ada transaksi</p></div></td></tr>
                    <?php else: ?>
                    <?php foreach ($penjualanTerbaru as $p): ?>
                    <tr>
                        <td class="number-col">#<?= $p['id_penjualan'] ?></td>
                        <td><?= date('d M Y H:i', strtotime($p['tanggal'])) ?></td>
                        <td><?= htmlspecialchars($p['pencatat']) ?></td>
                        <td><span class="badge badge-blue"><?= strtoupper($p['metode_bayar']) ?></span></td>
                        <td><strong>Rp <?= number_format($p['total'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>

