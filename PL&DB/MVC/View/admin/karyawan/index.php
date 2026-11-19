<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - Admin</title>
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
                <h1><i class="fa-solid fa-users"></i> Data Karyawan</h1>
                <p>Kelola akun karyawan toko ikan</p>
            </div>
            <a href="index.php?page=karyawan&aksi=tambah" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Tambah Karyawan</a>
        </div>

        <?php $status = $_GET['status'] ?? ''; ?>
        <?php if ($status === 'tambah_sukses'): ?>
            <div class="alert-toast success"><i class="fa-solid fa-circle-check"></i> Karyawan baru berhasil ditambahkan!</div>
        <?php elseif ($status === 'edit_sukses'): ?>
            <div class="alert-toast success"><i class="fa-solid fa-circle-check"></i> Data karyawan berhasil diperbarui!</div>
        <?php elseif ($status === 'hapus_sukses'): ?>
            <div class="alert-toast info"><i class="fa-solid fa-trash-can"></i> Karyawan berhasil dihapus!</div>
        <?php endif; ?>

        <div class="card">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="number-col">No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Peran</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($dataKaryawan)): ?>
                    <?php foreach ($dataKaryawan as $i => $k): ?>
                        <tr>
                            <td class="number-col"><?= $i + 1 ?></td>
                            <td>
                                <strong><?= htmlspecialchars($k['nama']) ?></strong>
                            </td>
                            <td>
                                <code>@<?= htmlspecialchars($k['username']) ?></code>
                            </td>
                            <td>
                                <span class="badge badge-teal"><?= ucfirst(htmlspecialchars($k['peran'])) ?></span>
                            </td>
                            <td class="action-col">
                                <a href="index.php?page=karyawan&aksi=edit&id=<?= $k['id_pengguna'] ?>" class="btn btn-warning btn-sm" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                <a href="index.php?page=karyawan&aksi=hapus&id=<?= $k['id_pengguna'] ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin hapus karyawan ini?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5"><div class="empty-state"><i class="fa-regular fa-folder-open"></i><h2>Belum ada karyawan</h2><p>Klik Tambah Karyawan untuk menambahkan data baru.</p></div></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <span>Total: <strong><?= count($dataKaryawan) ?></strong> karyawan</span>
            </div>
        </div>
    </main>
</div>
</body>
</html>

