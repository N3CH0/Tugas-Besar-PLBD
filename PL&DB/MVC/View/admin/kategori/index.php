<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori - Admin</title>
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
                <h1><i class="fa-solid fa-layer-group"></i> Data Kategori</h1>
                <p>Kelola kategori produk toko</p>
            </div>
            <a href="index.php?page=kategori&aksi=tambah" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Kategori</a>
        </div>

        <?php $status = $_GET['status'] ?? ''; ?>
        <?php if ($status === 'tambah_sukses'): ?>
            <div class="alert-toast success"><i class="fa-solid fa-circle-check"></i> Kategori berhasil ditambahkan!</div>
        <?php elseif ($status === 'edit_sukses'): ?>
            <div class="alert-toast success"><i class="fa-solid fa-circle-check"></i> Kategori berhasil diubah!</div>
        <?php elseif ($status === 'hapus_sukses'): ?>
            <div class="alert-toast info"><i class="fa-solid fa-trash-can"></i> Kategori berhasil dihapus!</div>
        <?php elseif ($status === 'hapus_gagal'): ?>
            <div class="alert-toast error"><i class="fa-solid fa-circle-exclamation"></i> Gagal menghapus! Kategori masih dipakai barang.</div>
        <?php endif; ?>

        <div class="card">
            <div class="table-container">
                <table>
                    <thead><tr><th class="number-col">No</th><th>Nama Kategori</th><th class="action-col">Aksi</th></tr></thead>
                    <tbody>
                    <?php if ($dataKategori): ?>
                    <?php foreach ($dataKategori as $i => $k): ?>
                        <tr>
                            <td class="number-col"><?= $i + 1 ?></td>
                            <td><strong><?= htmlspecialchars(ucfirst($k['nama_kategori'])) ?></strong></td>
                            <td class="action-col">
                                <a href="index.php?page=kategori&aksi=edit&id=<?= $k['id_kategori'] ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen"></i></a>
                                <a href="index.php?page=kategori&aksi=hapus&id=<?= $k['id_kategori'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kategori ini?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3"><div class="empty-state"><i class="fa-regular fa-folder-open"></i><h2>Belum ada kategori</h2></div></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <span>Total: <strong><?= count($dataKategori) ?></strong> kategori</span>
            </div>
        </div>
    </main>
</div>
</body>
</html>

