<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan - Admin</title>
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
                <h1><i class="fa-solid fa-receipt"></i> Detail Penjualan #<?= $penjualan['id_penjualan'] ?></h1>
                <p>Informasi lengkap transaksi</p>
            </div>
            <a href="index.php?page=penjualan" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>

        <!-- Info Card -->
        <div class="stats-grid" style="margin-bottom: 24px;">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-calendar"></i></div>
                <div>
                    <div class="stat-label">Tanggal</div>
                    <div style="font-weight: 700;"><?= date('d M Y H:i', strtotime($penjualan['tanggal'])) ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fa-solid fa-user"></i></div>
                <div>
                    <div class="stat-label">Pencatat</div>
                    <div style="font-weight: 700;"><?= htmlspecialchars($penjualan['pencatat']) ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon amber"><i class="fa-solid fa-credit-card"></i></div>
                <div>
                    <div class="stat-label">Metode</div>
                    <div style="font-weight: 700;"><?= strtoupper($penjualan['metode_bayar']) ?></div>
                </div>
            </div>
        </div>

        <!-- Detail Items -->
        <div class="card">
            <div class="card-header">
                <h2>Item Terjual</h2>
            </div>
            <div class="table-container">
                <table>
                    <thead><tr><th class="number-col">No</th><th>Barang</th><th>Jumlah</th><th>Harga Satuan</th><th>Subtotal</th></tr></thead>
                    <tbody>
                    <?php foreach ($detailPenjualan as $i => $d): ?>
                    <tr>
                        <td class="number-col"><?= $i + 1 ?></td>
                        <td><strong><?= htmlspecialchars($d['nama_barang']) ?></strong></td>
                        <td><?= $d['jumlah'] ?></td>
                        <td>Rp <?= number_format($d['harga_satuan'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <span></span>
                <span style="font-size: 16px;"><strong>TOTAL: Rp <?= number_format($penjualan['total'], 0, ',', '.') ?></strong></span>
            </div>
        </div>
    </main>
</div>
</body>
</html>

