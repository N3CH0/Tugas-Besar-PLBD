<?php
require_once __DIR__ . '/../Model/Barang.php';
require_once __DIR__ . '/../Model/Kategori.php';
require_once __DIR__ . '/../Model/Pengguna.php';

class GuestController
{
    private Barang $barang;
    private Kategori $kategori;

    public function __construct()
    {
        $this->barang = new Barang();
        $this->kategori = new Kategori();
    }

    public function jalankan(string $page): void
    {
        switch ($page) {
            case 'produk':
                $this->produk();
                break;
            case 'login':
                $this->login();
                break;
            default:
                $this->home();
                break;
        }
    }

    private function home(): void
    {
        $dataBarang = $this->barang->semua();
        $dataKategori = $this->kategori->semua();
        require __DIR__ . '/../View/guest/home.php';
    }

    private function produk(): void
    {
        $dataKategori = $this->kategori->semua();
        $id_kategori = filter_input(INPUT_GET, 'kategori', FILTER_VALIDATE_INT);

        if ($id_kategori) {
            $dataBarang = $this->barang->semuaByKategori($id_kategori);
            $kategoriAktif = $this->kategori->cariById($id_kategori);
        } else {
            $dataBarang = $this->barang->semua();
            $kategoriAktif = null;
        }

        require __DIR__ . '/../View/guest/produk.php';
    }

    private function login(): void
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=dashboard');
            exit;
        }

        $pesan = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $pengguna = new Pengguna();
            $user = $pengguna->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id_pengguna'];
                $_SESSION['user_nama'] = $user['nama'];
                $_SESSION['user_username'] = $user['username'];
                $_SESSION['user_peran'] = $user['peran'];
                header('Location: index.php?page=dashboard');
                exit;
            } else {
                $pesan = 'Username atau password salah!';
            }
        }

        require __DIR__ . '/../View/auth/login.php';
    }
}