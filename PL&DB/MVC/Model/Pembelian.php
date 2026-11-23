<?php
require_once __DIR__ . '/../koneksi.php';

class Pembelian
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
            'SELECT p.*, pm.nama_pemasok, u.nama AS pencatat 
             FROM pembelian p 
             JOIN pemasok pm ON pm.id_pemasok = p.id_pemasok 
             JOIN pengguna u ON u.id_pengguna = p.id_pengguna 
             ORDER BY p.id_pembelian DESC'
        );
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function detail(int $id): array
    {
        $stmt = $this->conn->prepare(
            'SELECT dp.*, b.nama_barang 
             FROM detail_pembelian dp 
             JOIN barang b ON b.id_barang = dp.id_barang 
             WHERE dp.id_pembelian = ?'
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
            'SELECT p.*, pm.nama_pemasok, u.nama AS pencatat 
             FROM pembelian p 
             JOIN pemasok pm ON pm.id_pemasok = p.id_pemasok 
             JOIN pengguna u ON u.id_pengguna = p.id_pengguna 
             WHERE p.id_pembelian = ?'
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function semuaPemasok(): array
    {
        $result = $this->conn->query('SELECT * FROM pemasok ORDER BY nama_pemasok ASC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function tambah(int $id_pengguna, int $id_pemasok, array $items): int
    {
        $this->conn->begin_transaction();
        try {
            $total = 0;
            foreach ($items as $item) {
                $total += $item['jumlah'] * $item['harga_beli'];
            }

            $stmt = $this->conn->prepare(
                'INSERT INTO pembelian (id_pemasok, id_pengguna, tanggal, total_biaya) VALUES (?, ?, CURDATE(), ?)'
            );
            $stmt->bind_param('iid', $id_pemasok, $id_pengguna, $total);
            $stmt->execute();
            $id_pembelian = $this->conn->insert_id;
            $stmt->close();

            $stmtDetail = $this->conn->prepare(
                'INSERT INTO detail_pembelian (id_pembelian, id_barang, jumlah, harga_beli, subtotal) VALUES (?, ?, ?, ?, ?)'
            );
            $stmtStok = $this->conn->prepare(
                'UPDATE barang SET stok = stok + ? WHERE id_barang = ?'
            );

            foreach ($items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_beli'];
                $stmtDetail->bind_param(
                    'iiidd',
                    $id_pembelian,
                    $item['id_barang'],
                    $item['jumlah'],
                    $item['harga_beli'],
                    $subtotal
                );
                $stmtDetail->execute();

                $stmtStok->bind_param('ii', $item['jumlah'], $item['id_barang']);
                $stmtStok->execute();
            }

            $stmtDetail->close();
            $stmtStok->close();

            $this->conn->commit();
            return $id_pembelian;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    public function hapus(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM pembelian WHERE id_pembelian = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $ok = $stmt->affected_rows > 0;
        $stmt->close();
        return $ok;
    }

    public function totalPembelian(): float
    {
        $result = $this->conn->query('SELECT COALESCE(SUM(total_biaya), 0) as total FROM pembelian');
        return (float) ($result ? $result->fetch_assoc()['total'] : 0);
    }

    public function jumlahTransaksi(): int
    {
        $result = $this->conn->query('SELECT COUNT(*) as total FROM pembelian');
        return (int) ($result ? $result->fetch_assoc()['total'] : 0);
    }
}

