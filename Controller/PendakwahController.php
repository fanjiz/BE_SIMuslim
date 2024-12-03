<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_logged_in'])) {
    // Jika belum login, arahkan ke halaman login_user_p.php
    header('Location: ../view/login_user_p.php');
    exit(); // Hentikan eksekusi setelah pengalihan
}

// Jika pengguna sudah login, lanjutkan proses lain, misalnya menampilkan dashboard
echo "Selamat datang di dashboard!";
?>
