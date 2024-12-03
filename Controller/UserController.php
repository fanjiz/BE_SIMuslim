<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_logged_in'])) {
    // Jika belum login, arahkan ke halaman login_user.php
    header('Location: ../view/login_user.php');
    exit(); // Hentikan eksekusi setelah pengalihan
}

// Jika sudah login, lanjutkan proses lain, misalnya menampilkan dashboard
echo "Selamat datang di dashboard!";
?>
