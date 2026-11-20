<?php
require_once __DIR__ . '/../koneksi.php';

class Pengguna
{
    private mysqli $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function login(string $username, string $password): ?array
    {
        $stmt = $this->conn->prepare('SELECT * FROM pengguna WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($user && $user['password'] === $password) {
            return $user;
        }
        return null;
    }

    public function semuaKaryawan(): array
    {
        $result = $this->conn->query(
            "SELECT * FROM pengguna WHERE peran = 'karyawan' ORDER BY id_pengguna DESC"
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function cariById(int $id): ?array
    {
        $stmt = $this->conn->prepare('SELECT * FROM pengguna WHERE id_pengguna = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function tambah(string $nama, string $username, string $password): void
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO pengguna (nama, username, password, peran) VALUES (?, ?, ?, 'karyawan')"
        );
        $stmt->bind_param('sss', $nama, $username, $password);
        $stmt->execute();
        $stmt->close();
    }

    public function ubah(int $id, string $nama, string $username, string $password = ''): void
    {
        if ($password !== '') {
            $stmt = $this->conn->prepare('UPDATE pengguna SET nama=?, username=?, password=? WHERE id_pengguna=?');
            $stmt->bind_param('sssi', $nama, $username, $password, $id);
        } else {
            $stmt = $this->conn->prepare('UPDATE pengguna SET nama=?, username=? WHERE id_pengguna=?');
            $stmt->bind_param('ssi', $nama, $username, $id);
        }
        $stmt->execute();
        $stmt->close();
    }

    public function hapus(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM pengguna WHERE id_pengguna = ? AND peran = 'karyawan'");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $ok = $stmt->affected_rows > 0;
        $stmt->close();
        return $ok;
    }
}