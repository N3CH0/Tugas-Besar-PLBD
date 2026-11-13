-- ================================================================
-- SQL Toko SCR Sinar Kasih
-- CREATE TABLE, ALTER TABLE, INSERT, SELECT, UPDATE, DELETE, JOIN
-- ================================================================

DROP DATABASE IF EXISTS db_toko_scr_sinar_kasih;

CREATE DATABASE db_toko_scr_sinar_kasih
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_toko_scr_sinar_kasih;

-- ================================================================
-- 1. CREATE TABLE
-- ================================================================
CREATE TABLE kategori_produk (
    id_kategori INT AUTO_INCREMENT,
    nama_kategori VARCHAR(50) NOT NULL,
    CONSTRAINT pk_kategori_produk PRIMARY KEY (id_kategori),
    CONSTRAINT uq_nama_kategori UNIQUE (nama_kategori)
) ENGINE=InnoDB;

CREATE TABLE produk (
    id_produk INT AUTO_INCREMENT,
    id_kategori INT NOT NULL,
    nama_produk VARCHAR(100) NOT NULL,
    satuan VARCHAR(20) NOT NULL DEFAULT 'pcs',
    harga_jual DECIMAL(12,2) NOT NULL,
    CONSTRAINT pk_produk PRIMARY KEY (id_produk),
    CONSTRAINT uq_nama_produk UNIQUE (nama_produk),
    CONSTRAINT fk_produk_kategori FOREIGN KEY (id_kategori)
        REFERENCES kategori_produk(id_kategori)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_harga_jual CHECK (harga_jual >= 0)
) ENGINE=InnoDB;

CREATE TABLE stok (
    id_stok INT AUTO_INCREMENT,
    id_produk INT NOT NULL,
    jumlah_stok INT NOT NULL DEFAULT 0,
    tanggal_diperbarui DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_stok PRIMARY KEY (id_stok),
    CONSTRAINT uq_stok_produk UNIQUE (id_produk),
    CONSTRAINT fk_stok_produk FOREIGN KEY (id_produk)
        REFERENCES produk(id_produk)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE pemasok (
    id_pemasok INT AUTO_INCREMENT,
    nama_pemasok VARCHAR(100) NOT NULL,
    CONSTRAINT pk_pemasok PRIMARY KEY (id_pemasok),
    CONSTRAINT uq_nama_pemasok UNIQUE (nama_pemasok)
) ENGINE=InnoDB;

CREATE TABLE sales (
    id_sales INT AUTO_INCREMENT,
    id_pemasok INT NOT NULL,
    nama_sales VARCHAR(100) NOT NULL,
    CONSTRAINT pk_sales PRIMARY KEY (id_sales),
    CONSTRAINT fk_sales_pemasok FOREIGN KEY (id_pemasok)
        REFERENCES pemasok(id_pemasok)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE nota_pembelian (
    id_pembelian INT AUTO_INCREMENT,
    id_pemasok INT NOT NULL,
    tanggal_pembelian DATE NOT NULL,
    total_pembelian DECIMAL(14,2) NOT NULL DEFAULT 0,
    CONSTRAINT pk_nota_pembelian PRIMARY KEY (id_pembelian),
    CONSTRAINT fk_nota_pemasok FOREIGN KEY (id_pemasok)
        REFERENCES pemasok(id_pemasok)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_total_pembelian CHECK (total_pembelian >= 0)
) ENGINE=InnoDB;

CREATE TABLE detail_pembelian (
    id_pembelian INT NOT NULL,
    id_produk INT NOT NULL,
    jumlah_beli INT NOT NULL,
    harga_beli DECIMAL(12,2) NOT NULL,
    CONSTRAINT pk_detail_pembelian PRIMARY KEY (id_pembelian, id_produk),
    CONSTRAINT fk_dpembelian_nota FOREIGN KEY (id_pembelian)
        REFERENCES nota_pembelian(id_pembelian)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_dpembelian_produk FOREIGN KEY (id_produk)
        REFERENCES produk(id_produk)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_jumlah_beli CHECK (jumlah_beli > 0),
    CONSTRAINT chk_harga_beli CHECK (harga_beli >= 0)
) ENGINE=InnoDB;

CREATE TABLE penjualan (
    id_penjualan INT AUTO_INCREMENT,
    tanggal_penjualan DATE NOT NULL,
    total_bayar DECIMAL(14,2) NOT NULL DEFAULT 0,
    metode_pembayaran VARCHAR(20) NOT NULL DEFAULT 'Tunai',
    CONSTRAINT pk_penjualan PRIMARY KEY (id_penjualan),
    CONSTRAINT chk_total_bayar CHECK (total_bayar >= 0)
) ENGINE=InnoDB;

CREATE TABLE detail_penjualan (
    id_penjualan INT NOT NULL,
    id_produk INT NOT NULL,
    jumlah_jual INT NOT NULL,
    harga_satuan DECIMAL(12,2) NOT NULL,
    CONSTRAINT pk_detail_penjualan PRIMARY KEY (id_penjualan, id_produk),
    CONSTRAINT fk_djual_penjualan FOREIGN KEY (id_penjualan)
        REFERENCES penjualan(id_penjualan)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_djual_produk FOREIGN KEY (id_produk)
        REFERENCES produk(id_produk)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_jumlah_jual CHECK (jumlah_jual > 0),
    CONSTRAINT chk_harga_satuan CHECK (harga_satuan >= 0)
) ENGINE=InnoDB;

-- HASIL CREATE TABLE
SHOW TABLES;
DESCRIBE kategori_produk;
DESCRIBE produk;
DESCRIBE stok;
DESCRIBE pemasok;
DESCRIBE sales;
DESCRIBE nota_pembelian;
DESCRIBE detail_pembelian;
DESCRIBE penjualan;
DESCRIBE detail_penjualan;

-- ================================================================
-- 2. ALTER TABLE
-- ================================================================
ALTER TABLE produk
    ADD INDEX idx_produk_nama (nama_produk);

ALTER TABLE penjualan
    ADD INDEX idx_penjualan_tanggal (tanggal_penjualan);

ALTER TABLE nota_pembelian
    ADD INDEX idx_pembelian_tanggal (tanggal_pembelian);

ALTER TABLE stok
    ADD CONSTRAINT chk_jumlah_stok CHECK (jumlah_stok >= 0);

-- HASIL ALTER TABLE
SHOW INDEX FROM produk;
SHOW INDEX FROM penjualan;
SHOW INDEX FROM nota_pembelian;
SHOW CREATE TABLE stok;

-- ================================================================
-- 3. INSERT
-- ================================================================
INSERT INTO kategori_produk (id_kategori, nama_kategori) VALUES
(1, 'Makanan'), (2, 'Minuman'), (3, 'Sabun'),
(4, 'Sabun Cuci Baju'), (5, 'Obatan');

INSERT INTO produk (id_produk, id_kategori, nama_produk, satuan, harga_jual) VALUES
(1, 1, 'Indomie', 'bungkus', 3500),
(2, 2, 'Aqua', 'botol', 4000),
(3, 3, 'Sunlight', 'sachet', 2000),
(4, 4, 'Rinso', 'sachet', 1500),
(5, 5, 'Paracetamol', 'strip', 5000);

INSERT INTO stok (id_stok, id_produk, jumlah_stok, tanggal_diperbarui) VALUES
(1, 1, 75, '2026-10-16 17:00:00'),
(2, 2, 60, '2026-10-16 17:00:00'),
(3, 3, 18, '2026-10-16 17:00:00'),
(4, 4, 40, '2026-10-16 17:00:00'),
(5, 5, 12, '2026-10-16 17:00:00');

INSERT INTO pemasok (id_pemasok, nama_pemasok) VALUES
(1, 'Indofood'), (2, 'ABC'), (3, 'Sedap'),
(4, 'Nasional'), (5, 'Beli Sendiri');

INSERT INTO sales (id_sales, id_pemasok, nama_sales) VALUES
(1, 1, 'Sales A'), (2, 1, 'Sales B'), (3, 2, 'Sales C'),
(4, 3, 'Sales D'), (5, 4, 'Sales E');

INSERT INTO nota_pembelian
(id_pembelian, id_pemasok, tanggal_pembelian, total_pembelian) VALUES
(1, 1, '2026-10-05', 120000),
(2, 5, '2026-10-07', 72000),
(3, 5, '2026-10-08', 45000),
(4, 5, '2026-10-10', 36000),
(5, 5, '2026-10-12', 70000);

INSERT INTO detail_pembelian
(id_pembelian, id_produk, jumlah_beli, harga_beli) VALUES
(1, 1, 40, 3000), (2, 2, 24, 3000),
(3, 3, 30, 1500), (4, 4, 30, 1200),
(5, 5, 20, 3500);

INSERT INTO penjualan
(id_penjualan, tanggal_penjualan, total_bayar, metode_pembayaran) VALUES
(1, '2026-10-14', 25500, 'Tunai'),
(2, '2026-10-14', 10000, 'Tunai'),
(3, '2026-10-15', 39000, 'Tunai'),
(4, '2026-10-15', 24000, 'Tunai'),
(5, '2026-10-16', 16500, 'Tunai');

INSERT INTO detail_penjualan
(id_penjualan, id_produk, jumlah_jual, harga_satuan) VALUES
(1, 1, 5, 3500), (1, 2, 2, 4000),
(2, 5, 2, 5000), (3, 1, 10, 3500),
(3, 3, 2, 2000), (4, 2, 6, 4000),
(5, 4, 5, 1500), (5, 5, 1, 5000),
(5, 2, 1, 4000);

-- HASIL INSERT
SELECT * FROM kategori_produk;
SELECT * FROM produk;
SELECT * FROM stok;
SELECT * FROM pemasok;
SELECT * FROM sales;
SELECT * FROM nota_pembelian;
SELECT * FROM detail_pembelian;
SELECT * FROM penjualan;
SELECT * FROM detail_penjualan;

-- ================================================================
-- 4. SELECT
-- ================================================================
-- HASIL SELECT 1: transaksi pada periode tertentu
SELECT id_penjualan, tanggal_penjualan, total_bayar, metode_pembayaran
FROM penjualan
WHERE tanggal_penjualan BETWEEN '2026-10-14' AND '2026-10-15'
ORDER BY tanggal_penjualan, id_penjualan;

-- HASIL SELECT 2: rekap penjualan harian
SELECT tanggal_penjualan,
       COUNT(*) AS jumlah_transaksi,
       SUM(total_bayar) AS total_pendapatan
FROM penjualan
GROUP BY tanggal_penjualan
ORDER BY tanggal_penjualan;

-- HASIL SELECT 3: pencarian barang berdasarkan nama
SELECT id_produk, nama_produk, satuan, harga_jual
FROM produk
WHERE nama_produk LIKE '%Rin%'
ORDER BY nama_produk;

-- HASIL SELECT 4: pembelian dengan nilai besar
SELECT id_pembelian, id_pemasok, tanggal_pembelian, total_pembelian
FROM nota_pembelian
WHERE total_pembelian > 50000
ORDER BY total_pembelian DESC;

-- ================================================================
-- 5. UPDATE
-- ================================================================
UPDATE produk
SET harga_jual = 3500
WHERE id_produk = 2;

-- HASIL UPDATE
SELECT ROW_COUNT() AS jumlah_baris_diubah;
SELECT id_produk, nama_produk, satuan, harga_jual
FROM produk
WHERE id_produk = 2;

-- ================================================================
-- 6. DELETE
-- ================================================================
DELETE FROM sales
WHERE id_sales = 5;

-- HASIL DELETE
SELECT ROW_COUNT() AS jumlah_baris_dihapus;
SELECT id_sales, id_pemasok, nama_sales
FROM sales
WHERE id_sales = 5;
SELECT id_sales, id_pemasok, nama_sales
FROM sales
ORDER BY id_sales;

-- ================================================================
-- 7. JOIN
-- ================================================================
-- HASIL JOIN 1: barang dengan stok menipis
SELECT p.nama_produk, p.satuan, s.jumlah_stok
FROM produk AS p
INNER JOIN stok AS s ON p.id_produk = s.id_produk
WHERE s.jumlah_stok < 20
ORDER BY s.jumlah_stok ASC;

-- HASIL JOIN 2: rincian penjualan
SELECT pj.id_penjualan,
       pj.tanggal_penjualan,
       p.nama_produk,
       dp.jumlah_jual,
       dp.harga_satuan,
       dp.jumlah_jual * dp.harga_satuan AS subtotal
FROM penjualan AS pj
INNER JOIN detail_penjualan AS dp ON pj.id_penjualan = dp.id_penjualan
INNER JOIN produk AS p ON dp.id_produk = p.id_produk
ORDER BY pj.id_penjualan, p.nama_produk;

-- HASIL JOIN 3: riwayat pembelian per pemasok
SELECT pm.nama_pemasok,
       np.tanggal_pembelian,
       p.nama_produk,
       dpb.jumlah_beli,
       dpb.harga_beli
FROM pemasok AS pm
INNER JOIN nota_pembelian AS np ON pm.id_pemasok = np.id_pemasok
INNER JOIN detail_pembelian AS dpb ON np.id_pembelian = dpb.id_pembelian
INNER JOIN produk AS p ON dpb.id_produk = p.id_produk
ORDER BY np.tanggal_pembelian, p.nama_produk;
