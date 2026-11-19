<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Toko Ikan Hias</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="View/style.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="guest-nav">
        <a href="index.php" class="logo">
            <i class="fa-solid fa-fish"></i>
            <span>Toko Ikan Hias</span>
        </a>
        <div class="nav-links">
            <a href="index.php"><i class="fa-solid fa-house"></i> Beranda</a>
            <a href="index.php?page=produk" class="active"><i class="fa-solid fa-store"></i> Produk</a>
            <a href="index.php?page=login" class="btn-login"><i class="fa-solid fa-right-to-bracket"></i> Login Admin</a>
        </div>
    </nav>

    <!-- FILTER CATEGORIES -->
    <section class="section" style="padding-bottom: 0;">
        <div class="section-title">
            <h2>Katalog Produk</h2>
            <p><?= $kategoriAktif ? 'Kategori: ' . htmlspecialchars(ucfirst($kategoriAktif['nama_kategori'])) : 'Menampilkan semua produk' ?></p>
        </div>
        <div class="category-grid">
            <a href="index.php?page=produk" class="category-card <?= !$kategoriAktif ? 'active' : '' ?>">
                <i class="fa-solid fa-border-all"></i>
                <span>Semua</span>
            </a>
            <?php
            $icons = ['ikan' => 'fa-fish', 'pakan' => 'fa-bowl-food', 'perlengkapan' => 'fa-gear', 'aksesoris' => 'fa-gem', 'obat' => 'fa-kit-medical'];
            foreach ($dataKategori as $kat):
                $icon = $icons[$kat['nama_kategori']] ?? 'fa-tag';
                $isActive = ($kategoriAktif && $kategoriAktif['id_kategori'] == $kat['id_kategori']) ? 'active' : '';
            ?>
            <a href="index.php?page=produk&kategori=<?= $kat['id_kategori'] ?>" class="category-card <?= $isActive ?>">
                <i class="fa-solid <?= $icon ?>"></i>
                <span><?= htmlspecialchars(ucfirst($kat['nama_kategori'])) ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- PRODUCTS -->
    <section class="section">
        <?php if (empty($dataBarang)): ?>
            <div class="empty-state">
                <i class="fa-regular fa-folder-open"></i>
                <h2>Tidak ada produk</h2>
                <p>Belum ada produk dalam kategori ini.</p>
            </div>
        <?php else: ?>
        <div class="product-grid">
            <?php
            foreach ($dataBarang as $b):
                $stokClass = $b['stok'] <= $b['stok_minimum'] ? 'menipis' : 'aman';
                $stokLabel = $b['stok'] <= $b['stok_minimum'] ? 'Stok Menipis' : 'Tersedia';

                // Cek ketersediaan foto di folder View/img/
                $imgPath = '';
                $extensions = ['jpg', 'jpeg', 'png', 'webp'];
                foreach ($extensions as $ext) {
                    if (file_exists(__DIR__ . '/../img/' . $b['id_barang'] . '.' . $ext)) {
                        $imgPath = 'View/img/' . $b['id_barang'] . '.' . $ext;
                        break;
                    } elseif (file_exists(__DIR__ . '/../img/barang_' . $b['id_barang'] . '.' . $ext)) {
                        $imgPath = 'View/img/barang_' . $b['id_barang'] . '.' . $ext;
                        break;
                    }
                }
            ?>
            <div class="product-card">
                <div class="product-img">
                    <span class="badge-kategori"><?= htmlspecialchars($b['nama_kategori']) ?></span>
                    <span class="badge-stok <?= $stokClass ?>"><?= $stokLabel ?></span>
                    <?php if ($imgPath): ?>
                        <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($b['nama_barang']) ?>">
                    <?php else: ?>
                        <!-- Placeholder Foto: Tambahkan gambar di View/img/<?= $b['id_barang'] ?>.jpg -->
                        <div class="product-placeholder">
                            <i class="fa-regular fa-image"></i>
                            <span>Foto Produk</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <h3><?= htmlspecialchars($b['nama_barang']) ?></h3>
                    <div class="price">Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?></div>
                    <div class="stock">Stok: <?= $b['stok'] ?> unit</div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>

    <!-- FOOTER -->
    <footer class="guest-footer">
        <p>&copy; <?= date('Y') ?> <strong>Toko Ikan Hias</strong> — Semua hak dilindungi.</p>
    </footer>
</body>
</html>
