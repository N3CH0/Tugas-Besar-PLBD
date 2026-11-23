<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Histori Pembelian - Admin</title>
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
                        <h1><i class="fa-solid fa-truck-ramp-box"></i> Histori Pembelian</h1>
                        <p>Riwayat pengadaan stok barang dari pemasok</p>
                    </div>
                    <a href="index.php?page=pembelian&aksi=tambah" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Pembelian Baru
                    </a>
                </div>
                <?php $status = $_GET['status'] ?? ''; ?>
                <?php if ($status === 'tambah_sukses'): ?>
                <div class="alert-toast success">
                    <i class="fa-solid fa-circle-check"></i> Transaksi pembelian berhasil dicatat!
                </div>
                <?php elseif ($status === 'hapus_sukses'): ?>
                <div class="alert-toast info">
                    <i class="fa-solid fa-trash-can"></i> Data pembelian berhasil dihapus!
                </div>
                <?php endif; ?>
                <div class="card">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th class="number-col">ID</th>
                                    <th>Tanggal</th>
                                    <th>Pemasok</th>
                                    <th>Pencatat</th>
                                    <th>Total Biaya</th>
                                    <th class="action-col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dataPembelian)): ?>
                                <?php foreach ($dataPembelian as $p): ?>
                                <tr>
                                    <td class="number-col">#<?= $p['id_pembelian'] ?></td>
                                    <td><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
                                    <td><strong><?= htmlspecialchars($p['nama_pemasok']) ?></strong></td>
                                    <td><?= htmlspecialchars($p['pencatat']) ?></td>
                                    <td><strong>Rp <?= number_format($p['total_biaya'], 0, ',', '.') ?></strong></td>
                                    <td class="action-col">
                                        <a href="index.php?page=pembelian&aksi=detail&id=<?= $p['id_pembelian'] ?>" class="btn btn-primary btn-sm" title="Detail">
                                            <i class="fa-solid fa-eye"></i></a>
                                        <a href="index.php?page=pembelian&aksi=hapus&id=<?= $p['id_pembelian'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data pembelian ini?')" title="Hapus">
                                            <i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6"><div class="empty-state"><i class="fa-regular fa-folder-open"></i><h2>Belum ada histori pembelian</h2></div></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        <span>Total: 
                            <strong><?= count($dataPembelian) ?></strong> transaksi pembelian
                        </span>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>