<?php
session_start();

$page = $_GET['page'] ?? 'home';

// Guest pages (no login required)
$guestPages = ['home', 'produk', 'login'];

// Admin pages (login required)
$adminPages = ['dashboard', 'barang', 'kategori', 'penjualan', 'karyawan', 'logout'];

if (in_array($page, $guestPages)) {
    require_once __DIR__ . '/Controller/GuestController.php';
    $controller = new GuestController();
    $controller->jalankan($page);
} elseif (in_array($page, $adminPages)) {
    if ($page === 'logout') {
        session_destroy();
        header('Location: index.php');
        exit;
    }
    // Check login
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit;
    }
    require_once __DIR__ . '/Controller/AdminController.php';
    $controller = new AdminController();
    $controller->jalankan($page);
} else {
    // Default to home
    require_once __DIR__ . '/Controller/GuestController.php';
    $controller = new GuestController();
    $controller->jalankan('home');
}

