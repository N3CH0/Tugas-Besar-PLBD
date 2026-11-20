CREATE DATABASE db_toko_ikan CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE db_toko_ikan;

CREATE TABLE pengguna (
    id_pengguna INT AUTO_INCREMENT,
    nama VARCHAR(50) NOT NULL,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    peran ENUM('pemilik', 'karyawan') NOT NULL DEFAULT 'karyawan',
    CONSTRAINT pk_pengguna PRIMARY KEY (id_pengguna),
    CONSTRAINT uq_pengguna_username UNIQUE (username)
) ENGINE = InnoDB;

CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT,
    nama_kategori VARCHAR(30) NOT NULL,
    CONSTRAINT pk_kategori PRIMARY KEY (id_kategori),
    CONSTRAINT uq_kategori_nama UNIQUE (nama_kategori)
) ENGINE = InnoDB;

CREATE TABLE barang (
    id_barang INT AUTO_INCREMENT,
    id_kategori INT NOT NULL,
    nama_barang VARCHAR(50) NOT NULL,
    harga_jual DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    stok INT NOT NULL DEFAULT 0,
    stok_minimum INT NOT NULL DEFAULT 0,
    CONSTRAINT pk_barang PRIMARY KEY (id_barang),
    CONSTRAINT fk_barang_kategori FOREIGN KEY (id_kategori) REFERENCES kategori (id_kategori) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_barang_harga CHECK (harga_jual >= 0),
    CONSTRAINT chk_barang_stok CHECK (stok >= 0),
    CONSTRAINT chk_barang_stok_min CHECK (stok_minimum >= 0)
) ENGINE = InnoDB;

CREATE TABLE penjualan (
    id_penjualan INT AUTO_INCREMENT,
    id_pengguna INT NOT NULL,
    tanggal DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    metode_bayar ENUM('tunai', 'qris') NOT NULL DEFAULT 'tunai',
    total DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    CONSTRAINT pk_penjualan PRIMARY KEY (id_penjualan),
    CONSTRAINT fk_penjualan_pengguna FOREIGN KEY (id_pengguna) REFERENCES pengguna (id_pengguna) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_penjualan_total CHECK (total >= 0)
) ENGINE = InnoDB;

CREATE TABLE detail_penjualan (
    id_penjualan INT NOT NULL,
    id_barang INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(12, 2) NOT NULL,
    subtotal DECIMAL(12, 2) NOT NULL,
    CONSTRAINT pk_detail_penjualan PRIMARY KEY (id_penjualan, id_barang),
    CONSTRAINT fk_dp_penjualan FOREIGN KEY (id_penjualan) REFERENCES penjualan (id_penjualan) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_dp_barang FOREIGN KEY (id_barang) REFERENCES barang (id_barang) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_dp_jumlah CHECK (jumlah > 0),
    CONSTRAINT chk_dp_harga CHECK (harga_satuan >= 0)
) ENGINE = InnoDB;

CREATE TABLE pemasok (
    id_pemasok INT AUTO_INCREMENT,
    nama_pemasok VARCHAR(50) NOT NULL,
    kota VARCHAR(30) NOT NULL,
    kontak VARCHAR(20) NULL,
    CONSTRAINT pk_pemasok PRIMARY KEY (id_pemasok)
) ENGINE = InnoDB;

CREATE TABLE pembelian (
    id_pembelian INT AUTO_INCREMENT,
    id_pemasok INT NOT NULL,
    id_pengguna INT NOT NULL,
    tanggal DATE NOT NULL DEFAULT(CURRENT_DATE),
    total_biaya DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    CONSTRAINT pk_pembelian PRIMARY KEY (id_pembelian),
    CONSTRAINT fk_pembelian_pemasok FOREIGN KEY (id_pemasok) REFERENCES pemasok (id_pemasok) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_pembelian_pengguna FOREIGN KEY (id_pengguna) REFERENCES pengguna (id_pengguna) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_pembelian_total CHECK (total_biaya >= 0)
) ENGINE = InnoDB;

CREATE TABLE detail_pembelian (
    id_pembelian INT NOT NULL,
    id_barang INT NOT NULL,
    jumlah INT NOT NULL,
    harga_beli DECIMAL(12, 2) NOT NULL,
    subtotal DECIMAL(12, 2) NOT NULL,
    CONSTRAINT pk_detail_pembelian PRIMARY KEY (id_pembelian, id_barang),
    CONSTRAINT fk_dpb_pembelian FOREIGN KEY (id_pembelian) REFERENCES pembelian (id_pembelian) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_dpb_barang FOREIGN KEY (id_barang) REFERENCES barang (id_barang) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_dpb_jumlah CHECK (jumlah > 0),
    CONSTRAINT chk_dpb_harga CHECK (harga_beli >= 0)
) ENGINE = InnoDB;

CREATE TABLE ikan_mati (
    id_ikan_mati INT AUTO_INCREMENT,
    id_barang INT NOT NULL,
    id_pengguna INT NOT NULL,
    tanggal DATE NOT NULL DEFAULT(CURRENT_DATE),
    jumlah INT NOT NULL,
    nilai_kerugian DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    CONSTRAINT pk_ikan_mati PRIMARY KEY (id_ikan_mati),
    CONSTRAINT fk_ikan_mati_barang FOREIGN KEY (id_barang) REFERENCES barang (id_barang) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_ikan_mati_pengguna FOREIGN KEY (id_pengguna) REFERENCES pengguna (id_pengguna) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_ikan_mati_jumlah CHECK (jumlah > 0),
    CONSTRAINT chk_ikan_mati_nilai CHECK (nilai_kerugian >= 0)
) ENGINE = InnoDB;

USE db_toko_ikan;

ALTER TABLE penjualan
MODIFY metode_bayar ENUM('tunai', 'transfer', 'qris') NOT NULL DEFAULT 'tunai';

ALTER TABLE barang
ADD CONSTRAINT uq_barang_nama UNIQUE (nama_barang);

ALTER TABLE penjualan ADD INDEX idx_penjualan_tanggal (tanggal);

ALTER TABLE pembelian ADD INDEX idx_pembelian_tanggal (tanggal);

ALTER TABLE ikan_mati ADD INDEX idx_ikan_mati_tanggal (tanggal);

ALTER TABLE detail_penjualan
ADD CONSTRAINT chk_dp_subtotal CHECK (
    subtotal = jumlah * harga_satuan
);

ALTER TABLE detail_pembelian
ADD CONSTRAINT chk_dpb_subtotal CHECK (
    subtotal = jumlah * harga_beli
);

USE db_toko_ikan;

INSERT INTO
    pengguna (
        nama,
        username,
        password,
        peran
    )
VALUES (
        'Azhar Maulani',
        'pemilik',
        '',
        'pemilik'
    ),
    (
        'Karyawan Toko',
        'karyawan',
        'karyawan',
        'karyawan'
    );

INSERT INTO
    kategori (nama_kategori)
VALUES ('ikan'),
    ('pakan'),
    ('perlengkapan'),
    ('aksesoris'),
    ('obat');

INSERT INTO
    barang (
        id_kategori,
        nama_barang,
        harga_jual,
        stok,
        stok_minimum
    )
VALUES (1, 'Moley', 10000, 27, 5),
    (1, 'Cupang', 25000, 19, 5),
    (1, 'Koki Panda', 30000, 10, 3),
    (1, 'Koi', 20000, 8, 3),
    (2, 'Pakan Ikan', 3000, 49, 10),
    (
        3,
        'Lampu Aquarium',
        40000,
        4,
        2
    ),
    (
        3,
        'Pompa Aquarium',
        65000,
        2,
        1
    ),
    (5, 'Obat Ikan', 14000, 12, 3),
    (4, 'Batu Hias', 14000, 20, 5);

INSERT INTO
    pemasok (nama_pemasok, kota, kontak)
VALUES (
        'Peternak Ikan Hias Tulungagung',
        'Tulungagung',
        '081200000000'
    );

INSERT INTO
    pembelian (
        id_pemasok,
        id_pengguna,
        tanggal,
        total_biaya
    )
VALUES (1, 2, '2026-10-10', 660000),
    (1, 2, '2026-10-11', 100000);

INSERT INTO
    detail_pembelian (
        id_pembelian,
        id_barang,
        jumlah,
        harga_beli,
        subtotal
    )
VALUES (1, 1, 30, 6000, 180000),
    (1, 2, 20, 15000, 300000),
    (1, 3, 10, 18000, 180000),
    (2, 5, 50, 2000, 100000);

INSERT INTO
    penjualan (
        id_pengguna,
        tanggal,
        metode_bayar,
        total
    )
VALUES (
        2,
        '2026-10-12',
        'tunai',
        10000
    ),
    (
        2,
        '2026-10-12',
        'tunai',
        40000
    ),
    (
        2,
        '2026-10-12',
        'tunai',
        65000
    ),
    (
        2,
        '2026-10-12',
        'transfer',
        28000
    );

INSERT INTO
    detail_penjualan (
        id_penjualan,
        id_barang,
        jumlah,
        harga_satuan,
        subtotal
    )
VALUES (1, 1, 1, 10000, 10000),
    (2, 6, 1, 40000, 40000),
    (3, 7, 1, 65000, 65000),
    (4, 2, 1, 25000, 25000),
    (4, 5, 1, 3000, 3000);

INSERT INTO
    ikan_mati (
        id_barang,
        id_pengguna,
        tanggal,
        jumlah,
        nilai_kerugian
    )
VALUES (1, 2, '2026-10-12', 2, 12000);

SELECT
    DATE(tanggal) AS tanggal,
    metode_bayar,
    COUNT(*) AS jumlah_transaksi,
    SUM(total) AS total_pemasukan
FROM penjualan
GROUP BY
    DATE(tanggal),
    metode_bayar
ORDER BY tanggal, metode_bayar;

SELECT
    nama_barang,
    stok,
    stok_minimum,
    CASE
        WHEN stok <= stok_minimum THEN 'MENIPIS'
        ELSE 'AMAN'
    END AS status_stok
FROM barang
ORDER BY (stok - stok_minimum), nama_barang;

SELECT (
        SELECT COALESCE(SUM(total), 0)
        FROM penjualan
    ) AS total_penjualan,
    (
        SELECT COALESCE(SUM(total_biaya), 0)
        FROM pembelian
    ) AS total_pembelian,
    (
        SELECT COALESCE(SUM(nilai_kerugian), 0)
        FROM ikan_mati
    ) AS total_kerugian,
    (
        SELECT COALESCE(SUM(total), 0)
        FROM penjualan
    ) - (
        SELECT COALESCE(SUM(total_biaya), 0)
        FROM pembelian
    ) - (
        SELECT COALESCE(SUM(nilai_kerugian), 0)
        FROM ikan_mati
    ) AS laba_rugi;

SELECT
    b.nama_barang,
    SUM(dp.jumlah) AS total_terjual,
    SUM(dp.subtotal) AS total_nilai
FROM
    detail_penjualan dp
    JOIN barang b ON b.id_barang = dp.id_barang
    JOIN kategori k ON k.id_kategori = b.id_kategori
WHERE
    k.nama_kategori = 'ikan'
GROUP BY
    b.id_barang,
    b.nama_barang
ORDER BY total_terjual DESC, b.nama_barang;

UPDATE barang SET harga_jual = 27000 WHERE nama_barang = 'Cupang';

SELECT
    id_barang,
    nama_barang,
    harga_jual
FROM barang
WHERE
    nama_barang = 'Cupang';

INSERT INTO
    penjualan (
        id_penjualan,
        id_pengguna,
        tanggal,
        metode_bayar,
        total
    )
VALUES (
        5,
        2,
        '2026-10-12',
        'tunai',
        10000
    );

INSERT INTO
    detail_penjualan (
        id_penjualan,
        id_barang,
        jumlah,
        harga_satuan,
        subtotal
    )
VALUES (5, 1, 1, 10000, 10000);

DELETE FROM penjualan WHERE id_penjualan = 5;

SELECT COUNT(*) FROM penjualan WHERE id_penjualan = 5;

SELECT COUNT(*) FROM detail_penjualan WHERE id_penjualan = 5;

SELECT p.id_penjualan, p.tanggal, u.nama AS pencatat, b.nama_barang, dp.jumlah, dp.harga_satuan, dp.subtotal, p.metode_bayar
FROM
    penjualan p
    JOIN pengguna u ON u.id_pengguna = p.id_pengguna
    JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
    JOIN barang b ON b.id_barang = dp.id_barang
ORDER BY p.id_penjualan, b.nama_barang;