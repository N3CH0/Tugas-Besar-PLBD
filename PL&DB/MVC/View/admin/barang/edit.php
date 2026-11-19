<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Admin</title>
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
                <h1><i class="fa-solid fa-pen"></i> Edit Barang</h1>
                <p>Ubah data produk: <?= htmlspecialchars($dataForm['nama_barang']) ?></p>
            </div>
            <a href="index.php?page=barang" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>

        <div class="card">
            <div class="form-body">
                <?php if ($pesan): ?>
                    <div class="alert-toast error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($pesan) ?></div>
                <?php endif; ?>
                <form action="index.php?page=barang&aksi=edit&id=<?= $dataForm['id_barang'] ?>" method="post">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <div class="input-group">
                            <i class="fa-solid fa-box"></i>
                            <input type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?= htmlspecialchars($dataForm['nama_barang']) ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_kategori">Kategori</label>
                        <div class="input-group">
                            <i class="fa-solid fa-layer-group"></i>
                            <select id="id_kategori" name="id_kategori" class="form-control" required>
                                <?php foreach ($dataKategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>" <?= $dataForm['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>><?= htmlspecialchars(ucfirst($k['nama_kategori'])) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <i class="fa-solid fa-chevron-down select-caret"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual (Rp)</label>
                        <div class="input-group">
                            <i class="fa-solid fa-tag"></i>
                            <input type="number" id="harga_jual" name="harga_jual" class="form-control" min="0" value="<?= $dataForm['harga_jual'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <div class="input-group">
                            <i class="fa-solid fa-cubes"></i>
                            <input type="number" id="stok" name="stok" class="form-control" min="0" value="<?= $dataForm['stok'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stok_minimum">Stok Minimum</label>
                        <div class="input-group">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <input type="number" id="stok_minimum" name="stok_minimum" class="form-control" min="0" value="<?= $dataForm['stok_minimum'] ?>" required>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a href="index.php?page=barang" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>

