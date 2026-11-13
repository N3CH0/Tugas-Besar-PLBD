-- Reset database agar seluruh script dapat dijalankan berulang
DROP DATABASE IF EXISTS db_toko_scr_sinar_kasih;

-- =====================================================================
-- SQL Toko SCR Sinar Kasih
-- Memuat: CREATE TABLE, ALTER TABLE, INSERT, SELECT, UPDATE, DELETE, JOIN
-- =====================================================================

CREATE DATABASE IF NOT EXISTS db_toko_scr_sinar_kasih
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_toko_scr_sinar_kasih;

-- =====================================================================
-- CREATE TABLE
-- =====================================================================
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

-- Hasil JOIN 3: riwayat pembelian per pemasok
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

-- Hasil CREATE TABLE: daftar tabel berhasil dibuat
SHOW TABLES;

-- Hasil CREATE TABLE: struktur tabel utama
DESCRIBE produk;
DESCRIBE stok;
DESCRIBE penjualan;
DESCRIBE detail_penjualan;
