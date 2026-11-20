<?php
require_once __DIR__ . '/../koneksi.php';

class Kategori
{
    private mysqli $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function semua(): array
    {
        $result = $this->conn->query('SELECT * FROM kategori ORDER BY id_kategori');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function cariById(int $id): ?array
    {
        $stmt = $this->conn->prepare('SELECT * FROM kategori WHERE id_kategori = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function tambah(string $nama): void
    {
        $stmt = $this->conn->prepare('INSERT INTO kategori (nama_kategori) VALUES (?)');
        $stmt->bind_param('s', $nama);
        $stmt->execute();
        $stmt->close();
    }

    public function ubah(int $id, string $nama): void
    {
        $stmt = $this->conn->prepare('UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?');
        $stmt->bind_param('si', $nama, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function hapus(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM kategori WHERE id_kategori = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $ok = $stmt->affected_rows > 0;
        $stmt->close();
        return $ok;
    }
}