<?php
require_once __DIR__ . '/../koneksi.php';

class Barang
{
    private mysqli $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function semua(): array
    {
        $result = $this->conn->query(
            'SELECT b.*, k.nama_kategori 
             FROM barang b 
             JOIN kategori k ON k.id_kategori = b.id_kategori 
             ORDER BY b.id_barang DESC'
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function semuaByKategori(int $id_kategori): array
    {
        $stmt = $this->conn->prepare(
            'SELECT b.*, k.nama_kategori 
             FROM barang b 
             JOIN kategori k ON k.id_kategori = b.id_kategori 
             WHERE b.id_kategori = ? 
             ORDER BY b.nama_barang'
        );
        $stmt->bind_param('i', $id_kategori);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function cariById(int $id): ?array
    {
        $stmt = $this->conn->prepare(
            'SELECT b.*, k.nama_kategori 
             FROM barang b 
             JOIN kategori k ON k.id_kategori = b.id_kategori 
             WHERE b.id_barang = ?'
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function tambah(int $id_kategori, string $nama, float $harga, int $stok, int $stok_min): void
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO barang (id_kategori, nama_barang, harga_jual, stok, stok_minimum) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('isdii', $id_kategori, $nama, $harga, $stok, $stok_min);
        $stmt->execute();
        $stmt->close();
    }

    public function ubah(int $id, int $id_kategori, string $nama, float $harga, int $stok, int $stok_min): void
    {
        $stmt = $this->conn->prepare(
            'UPDATE barang SET id_kategori=?, nama_barang=?, harga_jual=?, stok=?, stok_minimum=? WHERE id_barang=?'
        );
        $stmt->bind_param('isdiii', $id_kategori, $nama, $harga, $stok, $stok_min, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function hapus(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM barang WHERE id_barang = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $ok = $stmt->affected_rows > 0;
        $stmt->close();
        return $ok;
    }

    public function totalBarang(): int
    {
        $result = $this->conn->query('SELECT COUNT(*) as total FROM barang');
        return (int) $result->fetch_assoc()['total'];
    }

    public function stokMenipis(): array
    {
        $result = $this->conn->query(
            'SELECT b.*, k.nama_kategori FROM barang b 
             JOIN kategori k ON k.id_kategori = b.id_kategori 
             WHERE b.stok <= b.stok_minimum ORDER BY (b.stok - b.stok_minimum)'
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

