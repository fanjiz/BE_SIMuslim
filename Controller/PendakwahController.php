<?php
session_start(); // Start session

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_logged_in'])) {
    // Jika belum login, arahkan ke halaman login_user_p.php
    header('Location: ../view/login_user_p.php');
    exit(); // Hentikan eksekusi setelah pengalihan
}

// Jika pengguna sudah login, lanjutkan ke halaman registrasi pendakwah
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form registrasi
    $namaLengkap = $_POST['nama-lengkap'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dokumen = $_FILES['dokumen']['name'];

    // Proses upload dokumen
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($dokumen);
    if (move_uploaded_file($_FILES['dokumen']['tmp_name'], $targetFile)) {
        // Koneksi database
        include_once '../config/config.php';
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Persiapkan query untuk insert ke database
        $stmt = $conn->prepare("INSERT INTO pendakwah (nama_lengkap, email, password, dokumen) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $namaLengkap, $email, $hashedPassword, $dokumen);

        if ($stmt->execute()) {
            // Registrasi berhasil
            header("Location: ../view/success_page.php"); // Redirect to success page
        } else {
            echo json_encode(["error" => "Registrasi gagal"]);
        }
    } else {
        echo json_encode(["error" => "Gagal mengunggah dokumen"]);
    }
} else {
    // Jika tidak ada data POST, tampilkan halaman registrasi
    include_once '../view/registrasi_pendakwah.php';
}
?>
