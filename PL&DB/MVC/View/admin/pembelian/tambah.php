<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Pembelian Baru - Admin</title>
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
                <h1><i class="fa-solid fa-plus"></i> Catat Pembelian Stok</h1>
                <p>Tambah stok barang dari pemasok</p>
            </div>
            <a href="index.php?page=pembelian" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>
        <div class="card">
            <div class="form-body">
                <?php if (!empty($pesan)): ?>
                    <div class="alert-toast error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($pesan) ?></div>
                <?php endif; ?>
                <form action="index.php?page=pembelian&aksi=tambah" method="post">
                    <div class="form-group">
                        <label for="id_pemasok">Pemasok</label>
                        <div class="input-group">
                            <i class="fa-solid fa-truck"></i>
                            <select id="id_pemasok" name="id_pemasok" class="form-control" required>
                                <option value="">-- Pilih Pemasok --</option>
                                <?php foreach ($dataPemasok as $p): ?>
                                    <option value="<?= $p['id_pemasok'] ?>">
                                        <?= htmlspecialchars($p['nama_pemasok']) ?> (<?= htmlspecialchars($p['kota']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <i class="fa-solid fa-chevron-down select-caret"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Pilih Barang, Jumlah & Harga Beli Satuan</label>
                        <div id="item-list">
                            <div class="item-row" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: end;">
                                <div style="flex: 2;">
                                    <select name="id_barang[]" class="form-control" style="padding-left: 14px;" required>
                                        <option value="">-- Pilih Barang --</option>
                                        <?php foreach ($dataBarang as $b): ?>
                                            <option value="<?= $b['id_barang'] ?>">
                                                <?= htmlspecialchars($b['nama_barang']) ?> (Stok saat ini: <?= $b['stok'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <input type="number" name="jumlah[]" class="form-control" style="padding-left: 14px;" placeholder="Jumlah" min="1" value="1" required>
                                </div>
                                <div style="flex: 1.5;">
                                    <input type="number" name="harga_beli[]" class="form-control" style="padding-left: 14px;" placeholder="Harga Beli (Rp)" min="0" step="100" required>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()" style="height: 42px;">&times;</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="addItem()" style="margin-top: 8px;">
                            <i class="fa-solid fa-plus"></i> Tambah Item
                        </button>
                    </div>
                    <div class="btn-group">
                        <a href="index.php?page=pembelian" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Pembelian</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<script>
    function addItem() {
        const list = document.getElementById('item-list');
        const first = list.querySelector('.item-row');
        const clone = first.cloneNode(true);
        clone.querySelector('select').value = '';
        clone.querySelector('input[name="jumlah[]"]').value = '1';
        clone.querySelector('input[name="harga_beli[]"]').value = '';
        list.appendChild(clone);
    }
</script>
</body>
</html>

