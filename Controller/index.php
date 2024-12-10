<?php
session_start();
include('auth.php');
requireLogin();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'home':
        include('pages/home.php');
        break;
    case 'group':
        include('pages/group.php');
        break;
    case 'materi':
        include('pages/materi.php');
        break;
    default:
        echo "Halaman tidak ditemukan.";
}
?>
