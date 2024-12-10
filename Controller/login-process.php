<?php
session_start();
include('config.php');

// Mengambil data dari formulir login
$username = $_POST['username'];
$password = $_POST['password'];

// Validasi data login
$query = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $user['id'];
    header('Location: index.php');
} else {
    echo "Login gagal. Username atau password salah.";
}
?>
