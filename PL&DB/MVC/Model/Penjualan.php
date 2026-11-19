<?php
require_once __DIR__ . '/../koneksi.php';

class Penjualan
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
            'SELECT p.*, u.nama AS pencatat 
             FROM penjualan p 
             JOIN pengguna u ON u.id_pengguna = p.id_pengguna 
             ORDER BY p.id_penjualan DESC'
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function detail(int $id): array
    {
        $stmt = $this->conn->prepare(
            'SELECT dp.*, b.nama_barang 
             FROM detail_penjualan dp 
             JOIN barang b ON b.id_barang = dp.id_barang 
             WHERE dp.id_penjualan = ?'
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function cariById(int $id): ?array
    {
        $stmt = $this->conn->prepare(
            'SELECT p.*, u.nama AS pencatat 
             FROM penjualan p 
             JOIN pengguna u ON u.id_pengguna = p.id_pengguna 
             WHERE p.id_penjualan = ?'
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function tambah(int $id_pengguna, string $metode_bayar, array $items): int
    {
        $this->conn->begin_transaction();
        try {
            // Calculate total
            $total = 0;
            foreach ($items as $item) {
                $total += $item['jumlah'] * $item['harga_satuan'];
            }

            // Insert penjualan
            $stmt = $this->conn->prepare(
                'INSERT INTO penjualan (id_pengguna, metode_bayar, total) VALUES (?, ?, ?)'
            );
            $stmt->bind_param('isd', $id_pengguna, $metode_bayar, $total);
            $stmt->execute();
            $id_penjualan = $this->conn->insert_id;
            $stmt->close();

            // Insert detail + update stok
            $stmtDetail = $this->conn->prepare(
                'INSERT INTO detail_penjualan (id_penjualan, id_barang, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)'
            );
            $stmtStok = $this->conn->prepare(
                'UPDATE barang SET stok = stok - ? WHERE id_barang = ?'
            );

            foreach ($items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                $stmtDetail->bind_param(
                    'iiidd',
                    $id_penjualan,
                    $item['id_barang'],
                    $item['jumlah'],
                    $item['harga_satuan'],
                    $subtotal
                );
                $stmtDetail->execute();

                $stmtStok->bind_param('ii', $item['jumlah'], $item['id_barang']);
                $stmtStok->execute();
            }

            $stmtDetail->close();
            $stmtStok->close();

            $this->conn->commit();
            return $id_penjualan;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    public function hapus(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM penjualan WHERE id_penjualan = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $ok = $stmt->affected_rows > 0;
        $stmt->close();
        return $ok;
    }

    public function totalPenjualan(): float
    {
        $result = $this->conn->query('SELECT COALESCE(SUM(total), 0) as total FROM penjualan');
        return (float) $result->fetch_assoc()['total'];
    }

    public function jumlahTransaksi(): int
    {
        $result = $this->conn->query('SELECT COUNT(*) as total FROM penjualan');
        return (int) $result->fetch_assoc()['total'];
    }
}

