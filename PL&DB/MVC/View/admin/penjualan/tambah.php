<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Transaksi Baru - Admin</title>
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
                        <h1><i class="fa-solid fa-plus"></i> Transaksi Baru</h1>
                        <p>Catat penjualan baru</p>
                    </div>
                    <a href="index.php?page=penjualan" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="card">
                    <div class="form-body">
                        <?php if ($pesan): ?>
                            <div class="alert-toast error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($pesan) ?></div>
                        <?php endif; ?>
                        <form action="index.php?page=penjualan&aksi=tambah" method="post">
                            <div class="form-group">
                                <label for="metode_bayar">Metode Pembayaran</label>
                                <div class="input-group">
                                    <i class="fa-solid fa-credit-card"></i>
                                    <select id="metode_bayar" name="metode_bayar" class="form-control" required>
                                        <option value="tunai">Tunai</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="qris">QRIS</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down select-caret"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilih Barang & Jumlah</label>
                                <div id="item-list">
                                    <div class="item-row" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: end;">
                                        <div style="flex: 2;">
                                            <select name="id_barang[]" class="form-control" style="padding-left: 14px;" required onchange="updateHarga(this)">
                                                <option value="">-- Pilih Barang --</option>
                                                <?php foreach ($dataBarang as $b): ?>
                                               <option value="<?= $b['id_barang'] ?>" data-harga="<?= $b['harga_jual'] ?>" data-stok="<?= $b['stok'] ?>">
                                                    <?= htmlspecialchars($b['nama_barang']) ?> (Stok: <?= $b['stok'] ?>) - Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div style="flex: 1;">
                                            <input type="number" name="jumlah[]" class="form-control" style="padding-left: 14px;" placeholder="Jumlah" min="1" value="1" required>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.item-row').remove()" style="height: 42px;">&times;</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="addItem()" style="margin-top: 8px;">
                                    <i class="fa-solid fa-plus"></i> Tambah Item
                                </button>
                            </div>
                            <div class="btn-group">
                                <a href="index.php?page=penjualan" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Batal</a>
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
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
            clone.querySelector('input[type="number"]').value = '1';
            list.appendChild(clone);
            }
        </script>
    </body>
</html>