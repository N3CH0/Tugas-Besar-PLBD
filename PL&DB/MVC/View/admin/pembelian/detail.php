<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Pembelian - Admin</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="View/style.css">
    </head>
    <body>
        <div class="admin-layout">
            <?php require __DIR__ . '/../../templates/sidebar.php';?>
            <main class="admin-main">
                <div class="page-header">
                    <div>
                        <h1><i class="fa-solid fa-receipt"></i> Detail Pembelian #<?= $pembelian['id_pembelian'] ?></h1>
                        <p>Informasi lengkap pembelian dari pemasok</p>
                    </div>
                    <a href="index.php?page=pembelian" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="stats-grid" style="margin-bottom: 24px;">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fa-solid fa-calendar"></i>
                        </div>
                        <div>
                            <div class="stat-label">Tanggal</div>
                            <div style="font-weight: 700;">
                                <?= date('d M Y', strtotime($pembelian['tanggal']))?>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fa-solid fa-truck"></i>
                        </div>
                        <div>
                            <div class="stat-label">Pemasok</div>
                            <div style="font-weight: 700;">
                                <?= htmlspecialchars($pembelian['nama_pemasok'])?>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon amber">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <div class="stat-label">Pencatat</div>
                            <div style="font-weight: 700;">
                                <?= htmlspecialchars($pembelian['pencatat'])?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fa-solid fa-boxes-stacked"></i> Rincian Barang Dibeli</h2>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th class="number-col">No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Beli</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detailPembelian as $i => $d): ?>
                                <tr>
                                    <td class="number-col"><?= $i + 1 ?></td>
                                    <td><strong><?= htmlspecialchars($d['nama_barang']) ?></strong></td>
                                    <td><?= $d['jumlah'] ?> unit</td>
                                    <td>Rp <?= number_format($d['harga_beli'], 0, ',', '.') ?></td>
                                    <td><strong>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></strong></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr style="background: #f8fafc; font-weight: 700;">
                                    <td colspan="4" style="text-align: right; padding: 14px 18px;">Total Biaya:</td>
                                    <td style="color: var(--primary); font-size: 16px; padding: 14px 18px;">
                                        Rp <?= number_format($pembelian['total_biaya'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>