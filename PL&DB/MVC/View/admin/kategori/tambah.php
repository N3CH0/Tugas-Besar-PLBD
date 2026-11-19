<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Admin</title>
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
                <h1><i class="fa-solid fa-plus"></i> Tambah Kategori</h1>
                <p>Tambahkan kategori produk baru</p>
            </div>
            <a href="index.php?page=kategori" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>

        <div class="card">
            <div class="form-body">
                <?php if ($pesan): ?>
                    <div class="alert-toast error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($pesan) ?></div>
                <?php endif; ?>
                <form action="index.php?page=kategori&aksi=tambah" method="post">
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <div class="input-group">
                            <i class="fa-solid fa-tag"></i>
                            <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" placeholder="Contoh: ikan" value="<?= htmlspecialchars($dataForm['nama_kategori']) ?>" required>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a href="index.php?page=kategori" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>

