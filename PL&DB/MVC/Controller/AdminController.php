<?php
require_once __DIR__ . '/../Model/Barang.php';
require_once __DIR__ . '/../Model/Kategori.php';
require_once __DIR__ . '/../Model/Penjualan.php';
require_once __DIR__ . '/../Model/Pengguna.php';

class AdminController
{
    private Barang $barang;
    private Kategori $kategori;
    private Penjualan $penjualan;
    private Pengguna $pengguna;

    public function __construct()
    {
        $this->barang = new Barang();
        $this->kategori = new Kategori();
        $this->penjualan = new Penjualan();
        $this->pengguna = new Pengguna();
    }

    public function jalankan(string $page): void
    {
        switch ($page) {
            case 'barang':
                $this->barang();
                break;
            case 'kategori':
                $this->kategori();
                break;
            case 'penjualan':
                $this->penjualan();
                break;
            case 'karyawan':
                $this->karyawan();
                break;
            default:
                $this->dashboard();
                break;
        }
    }

    private function dashboard(): void
    {
        $totalBarang = $this->barang->totalBarang();
        $totalPenjualan = $this->penjualan->totalPenjualan();
        $jumlahTransaksi = $this->penjualan->jumlahTransaksi();
        $stokMenipis = $this->barang->stokMenipis();
        $penjualanTerbaru = array_slice($this->penjualan->semua(), 0, 5);
        require __DIR__ . '/../View/admin/dashboard/index.php';
    }

    private function barang(): void
    {
        $aksi = $_GET['aksi'] ?? 'index';
        $status = $_GET['status'] ?? '';

        switch ($aksi) {
            case 'tambah':
                $this->barangTambah();
                break;
            case 'edit':
                $this->barangEdit();
                break;
            case 'hapus':
                $this->barangHapus();
                break;
            default:
                $dataBarang = $this->barang->semua();
                $dataKategori = $this->kategori->semua();
                require __DIR__ . '/../View/admin/barang/index.php';
                break;
        }
    }

    private function barangTambah(): void
    {
        $pesan = '';
        $dataKategori = $this->kategori->semua();
        $dataForm = ['id_kategori' => '', 'nama_barang' => '', 'harga_jual' => '', 'stok' => '', 'stok_minimum' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataForm = [
                'id_kategori' => (int) ($_POST['id_kategori'] ?? 0),
                'nama_barang' => trim($_POST['nama_barang'] ?? ''),
                'harga_jual' => (float) ($_POST['harga_jual'] ?? 0),
                'stok' => (int) ($_POST['stok'] ?? 0),
                'stok_minimum' => (int) ($_POST['stok_minimum'] ?? 0),
            ];

            if ($dataForm['nama_barang'] === '' || $dataForm['id_kategori'] === 0) {
                $pesan = 'Nama barang dan kategori wajib diisi.';
            } else {
                try {
                    $this->barang->tambah(
                        $dataForm['id_kategori'],
                        $dataForm['nama_barang'],
                        $dataForm['harga_jual'],
                        $dataForm['stok'],
                        $dataForm['stok_minimum']
                    );
                    header('Location: index.php?page=barang&status=tambah_sukses');
                    exit;
                } catch (mysqli_sql_exception $e) {
                    $pesan = 'Gagal menyimpan. Nama barang mungkin sudah ada.';
                }
            }
        }
        require __DIR__ . '/../View/admin/barang/tambah.php';
    }

    private function barangEdit(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) { header('Location: index.php?page=barang'); exit; }

        $dataForm = $this->barang->cariById($id);
        if (!$dataForm) { header('Location: index.php?page=barang'); exit; }

        $pesan = '';
        $dataKategori = $this->kategori->semua();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataForm = [
                'id_barang' => $id,
                'id_kategori' => (int) ($_POST['id_kategori'] ?? 0),
                'nama_barang' => trim($_POST['nama_barang'] ?? ''),
                'harga_jual' => (float) ($_POST['harga_jual'] ?? 0),
                'stok' => (int) ($_POST['stok'] ?? 0),
                'stok_minimum' => (int) ($_POST['stok_minimum'] ?? 0),
            ];

            if ($dataForm['nama_barang'] === '') {
                $pesan = 'Nama barang wajib diisi.';
            } else {
                try {
                    $this->barang->ubah($id, $dataForm['id_kategori'], $dataForm['nama_barang'], $dataForm['harga_jual'], $dataForm['stok'], $dataForm['stok_minimum']);
                    header('Location: index.php?page=barang&status=edit_sukses');
                    exit;
                } catch (mysqli_sql_exception $e) {
                    $pesan = 'Gagal mengubah data.';
                }
            }
        }
        require __DIR__ . '/../View/admin/barang/edit.php';
    }

    private function barangHapus(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            try {
                $this->barang->hapus($id);
                header('Location: index.php?page=barang&status=hapus_sukses');
            } catch (mysqli_sql_exception $e) {
                header('Location: index.php?page=barang&status=hapus_gagal');
            }
            exit;
        }
        header('Location: index.php?page=barang');
        exit;
    }

    private function kategori(): void
    {
        $aksi = $_GET['aksi'] ?? 'index';
        $status = $_GET['status'] ?? '';

        switch ($aksi) {
            case 'tambah':
                $this->kategoriTambah();
                break;
            case 'edit':
                $this->kategoriEdit();
                break;
            case 'hapus':
                $this->kategoriHapus();
                break;
            default:
                $dataKategori = $this->kategori->semua();
                require __DIR__ . '/../View/admin/kategori/index.php';
                break;
        }
    }

    private function kategoriTambah(): void
    {
        $pesan = '';
        $dataForm = ['nama_kategori' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataForm['nama_kategori'] = trim($_POST['nama_kategori'] ?? '');
            if ($dataForm['nama_kategori'] === '') {
                $pesan = 'Nama kategori wajib diisi.';
            } else {
                try {
                    $this->kategori->tambah($dataForm['nama_kategori']);
                    header('Location: index.php?page=kategori&status=tambah_sukses');
                    exit;
                } catch (mysqli_sql_exception $e) {
                    $pesan = 'Kategori sudah ada.';
                }
            }
        }
        require __DIR__ . '/../View/admin/kategori/tambah.php';
    }

    private function kategoriEdit(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) { header('Location: index.php?page=kategori'); exit; }

        $dataForm = $this->kategori->cariById($id);
        if (!$dataForm) { header('Location: index.php?page=kategori'); exit; }

        $pesan = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataForm['nama_kategori'] = trim($_POST['nama_kategori'] ?? '');
            if ($dataForm['nama_kategori'] === '') {
                $pesan = 'Nama kategori wajib diisi.';
            } else {
                try {
                    $this->kategori->ubah($id, $dataForm['nama_kategori']);
                    header('Location: index.php?page=kategori&status=edit_sukses');
                    exit;
                } catch (mysqli_sql_exception $e) {
                    $pesan = 'Gagal mengubah kategori.';
                }
            }
        }
        require __DIR__ . '/../View/admin/kategori/edit.php';
    }

    private function kategoriHapus(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            try {
                $this->kategori->hapus($id);
                header('Location: index.php?page=kategori&status=hapus_sukses');
            } catch (mysqli_sql_exception $e) {
                header('Location: index.php?page=kategori&status=hapus_gagal');
            }
            exit;
        }
        header('Location: index.php?page=kategori');
        exit;
    }

    private function penjualan(): void
    {
        $aksi = $_GET['aksi'] ?? 'index';
        $status = $_GET['status'] ?? '';

        switch ($aksi) {
            case 'tambah':
                $this->penjualanTambah();
                break;
            case 'detail':
                $this->penjualanDetail();
                break;
            case 'hapus':
                $this->penjualanHapus();
                break;
            default:
                $dataPenjualan = $this->penjualan->semua();
                require __DIR__ . '/../View/admin/penjualan/index.php';
                break;
        }
    }

    private function penjualanTambah(): void
    {
        $pesan = '';
        $dataBarang = $this->barang->semua();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $metode_bayar = $_POST['metode_bayar'] ?? 'tunai';
            $items = [];

            if (isset($_POST['id_barang']) && is_array($_POST['id_barang'])) {
                for ($i = 0; $i < count($_POST['id_barang']); $i++) {
                    if ($_POST['jumlah'][$i] > 0) {
                        $barangInfo = $this->barang->cariById((int) $_POST['id_barang'][$i]);
                        $items[] = [
                            'id_barang' => (int) $_POST['id_barang'][$i],
                            'jumlah' => (int) $_POST['jumlah'][$i],
                            'harga_satuan' => (float) $barangInfo['harga_jual'],
                        ];
                    }
                }
            }

            if (empty($items)) {
                $pesan = 'Pilih minimal satu barang.';
            } else {
                try {
                    $this->penjualan->tambah($_SESSION['user_id'], $metode_bayar, $items);
                    header('Location: index.php?page=penjualan&status=tambah_sukses');
                    exit;
                } catch (Exception $e) {
                    $pesan = 'Gagal menyimpan penjualan: ' . $e->getMessage();
                }
            }
        }
        require __DIR__ . '/../View/admin/penjualan/tambah.php';
    }

    private function penjualanDetail(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) { header('Location: index.php?page=penjualan'); exit; }

        $penjualan = $this->penjualan->cariById($id);
        $detailPenjualan = $this->penjualan->detail($id);

        if (!$penjualan) { header('Location: index.php?page=penjualan'); exit; }
        require __DIR__ . '/../View/admin/penjualan/detail.php';
    }

    private function penjualanHapus(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->penjualan->hapus($id);
            header('Location: index.php?page=penjualan&status=hapus_sukses');
            exit;
        }
        header('Location: index.php?page=penjualan');
        exit;
    }

    private function karyawan(): void
    {
        if ($_SESSION['user_peran'] !== 'pemilik') {
            header('Location: index.php?page=dashboard');
            exit;
        }

        $aksi = $_GET['aksi'] ?? 'index';
        $status = $_GET['status'] ?? '';

        switch ($aksi) {
            case 'tambah':
                $this->karyawanTambah();
                break;
            case 'edit':
                $this->karyawanEdit();
                break;
            case 'hapus':
                $this->karyawanHapus();
                break;
            default:
                $dataKaryawan = $this->pengguna->semuaKaryawan();
                require __DIR__ . '/../View/admin/karyawan/index.php';
                break;
        }
    }

    private function karyawanTambah(): void
    {
        $pesan = '';
        $dataForm = ['nama' => '', 'username' => '', 'password' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataForm = [
                'nama' => trim($_POST['nama'] ?? ''),
                'username' => trim($_POST['username'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
            ];

            if ($dataForm['nama'] === '' || $dataForm['username'] === '') {
                $pesan = 'Nama dan username wajib diisi.';
            } else {
                try {
                    $this->pengguna->tambah($dataForm['nama'], $dataForm['username'], $dataForm['password']);
                    header('Location: index.php?page=karyawan&status=tambah_sukses');
                    exit;
                } catch (mysqli_sql_exception $e) {
                    $pesan = 'Username sudah digunakan.';
                }
            }
        }
        require __DIR__ . '/../View/admin/karyawan/tambah.php';
    }

    private function karyawanEdit(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) { header('Location: index.php?page=karyawan'); exit; }

        $dataForm = $this->pengguna->cariById($id);
        if (!$dataForm) { header('Location: index.php?page=karyawan'); exit; }

        $pesan = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataForm['nama'] = trim($_POST['nama'] ?? '');
            $dataForm['username'] = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($dataForm['nama'] === '' || $dataForm['username'] === '') {
                $pesan = 'Nama dan username wajib diisi.';
            } else {
                try {
                    $this->pengguna->ubah($id, $dataForm['nama'], $dataForm['username'], $password);
                    header('Location: index.php?page=karyawan&status=edit_sukses');
                    exit;
                } catch (mysqli_sql_exception $e) {
                    $pesan = 'Gagal mengubah data.';
                }
            }
        }
        require __DIR__ . '/../View/admin/karyawan/edit.php';
    }

    private function karyawanHapus(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->pengguna->hapus($id);
            header('Location: index.php?page=karyawan&status=hapus_sukses');
            exit;
        }
        header('Location: index.php?page=karyawan');
        exit;
    }
}