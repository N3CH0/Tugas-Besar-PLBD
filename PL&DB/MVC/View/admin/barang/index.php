<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Admin</title>
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
                <h1><i class="fa-solid fa-box"></i> Data Barang</h1>
                <p>Kelola semua produk toko ikan hias</p>
            </div>
            <a href="index.php?page=barang&aksi=tambah" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Barang</a>
        </div>

        <?php $status = $_GET['status'] ?? ''; ?>
        <?php if ($status === 'tambah_sukses'): ?>
            <div class="alert-toast success"><i class="fa-solid fa-circle-check"></i> Barang berhasil ditambahkan!</div>
        <?php elseif ($status === 'edit_sukses'): ?>
            <div class="alert-toast success"><i class="fa-solid fa-circle-check"></i> Barang berhasil diubah!</div>
        <?php elseif ($status === 'hapus_sukses'): ?>
            <div class="alert-toast info"><i class="fa-solid fa-trash-can"></i> Barang berhasil dihapus!</div>
        <?php elseif ($status === 'hapus_gagal'): ?>
            <div class="alert-toast error"><i class="fa-solid fa-circle-exclamation"></i> Gagal menghapus! Barang masih terkait data lain.</div>
        <?php endif; ?>

        <div class="card">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="number-col">No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Min</th>
                            <th>Status</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($dataBarang): ?>
                    <?php foreach ($dataBarang as $i => $b): ?>
                        <tr>
                            <td class="number-col"><?= $i + 1 ?></td>
                            <td><strong><?= htmlspecialchars($b['nama_barang']) ?></strong></td>
                            <td><span class="badge badge-teal"><?= htmlspecialchars($b['nama_kategori']) ?></span></td>
                            <td>Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?></td>
                            <td><?= $b['stok'] ?></td>
                            <td><?= $b['stok_minimum'] ?></td>
                            <td>
                                <?php if ($b['stok'] <= $b['stok_minimum']): ?>
                                    <span class="badge badge-red">Menipis</span>
                                <?php else: ?>
                                    <span class="badge badge-green">Aman</span>
                                <?php endif; ?>
                            </td>
                            <td class="action-col">
                                <a href="index.php?page=barang&aksi=edit&id=<?= $b['id_barang'] ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
                                <a href="index.php?page=barang&aksi=hapus&id=<?= $b['id_barang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus barang ini?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8"><div class="empty-state"><i class="fa-regular fa-folder-open"></i><h2>Belum ada barang</h2><p>Klik Tambah Barang untuk menambahkan.</p></div></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <span>Total: <strong><?= count($dataBarang) ?></strong> barang</span>
            </div>
        </div>
    </main>
</div>
</body>
</html>

