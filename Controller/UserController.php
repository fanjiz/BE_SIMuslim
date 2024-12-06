<?php
session_start();

// Koneksi ke database
$host = "localhost"; // Host database
$user = "root";      // Username MySQL
$password = "";      // Password MySQL
$dbname = "simuslim";

// Buat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap aksi dari URL
if (isset($_GET['action']) && $_GET['action'] === 'login') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query untuk mendapatkan data user berdasarkan username
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Ambil password hash dari database
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verifikasi password
            if (password_verify($password, $hashed_password)) {
                // Login berhasil
                session_start();
                $_SESSION['username'] = $username; // Set sesi username
                header("Location: ../view/homepage/home.html");
                exit;
            } else {
                // Password salah
                header("Location: ../view/login_user.php?error=password");
                exit;
            }
        } else {
            // Username tidak ditemukan
            header("Location: ../view/login_user.php?error=username");
            exit;
        }

        $stmt->close();
    }
}

$conn->close();
?>
