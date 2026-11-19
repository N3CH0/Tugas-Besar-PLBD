<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karyawan - Admin</title>
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
                <h1><i class="fa-solid fa-user-pen"></i> Edit Karyawan</h1>
                <p>Perbarui informasi akun karyawan: <?= htmlspecialchars($dataForm['nama']) ?></p>
            </div>
            <a href="index.php?page=karyawan" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>

        <div class="card">
            <div class="form-body">
                <?php if (!empty($pesan)): ?>
                    <div class="alert-toast error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($pesan) ?></div>
                <?php endif; ?>
                <form action="index.php?page=karyawan&aksi=edit&id=<?= $dataForm['id_pengguna'] ?>" method="post">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <div class="input-group">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="nama" name="nama" class="form-control" value="<?= htmlspecialchars($dataForm['nama']) ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <i class="fa-solid fa-at"></i>
                            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($dataForm['username']) ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru (Kosongkan jika tidak diubah)</label>
                        <div class="input-group">
                            <i class="fa-solid fa-lock"></i>
                            <input type="text" id="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diubah">
                        </div>
                    </div>
                    <div class="btn-group">
                        <a href="index.php?page=karyawan" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>

