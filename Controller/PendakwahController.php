<?php
session_start(); // Memulai sesi

// Cek apakah metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form registrasi
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dokumen = $_FILES['dokumen'];

    // Cek apakah email sudah terdaftar
    include_once 'config.php'; // Koneksi database
    $stmt = $conn->prepare("SELECT * FROM pendakwah WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika email sudah terdaftar, redirect ke halaman registrasi dengan pesan error
        header("Location: ../view/registrasi_pendakwah.php?error=email_exists");
        exit();
    }

    // Validasi ukuran file (max 5MB)
    if ($dokumen['size'] > 5242880) {
        echo json_encode(["error" => "Ukuran file tidak boleh lebih dari 5MB"]);
        exit();
    }

    // Validasi jenis file
    $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($dokumen['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedTypes)) {
        echo json_encode(["error" => "Hanya file PDF, JPG, JPEG, atau PNG yang diperbolehkan"]);
        exit();
    }

    // Proses upload dokumen
    $targetDir = "../uploads/";
    $uniqueFileName = uniqid() . '.' . $fileExtension; // Beri nama unik pada file
    $targetFile = $targetDir . $uniqueFileName;

    if (move_uploaded_file($dokumen['tmp_name'], $targetFile)) {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Persiapkan query untuk insert ke database
        $stmt = $conn->prepare("INSERT INTO pendakwah (username, email, password, uploaded_file, file_size) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $username, $email, $hashedPassword, $uniqueFileName, $dokumen['size']);

        if ($stmt->execute()) {
            // Jika registrasi berhasil, arahkan ke halaman login pendakwah
            header("Location: ../view/login_pendakwah.php");
            exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
        } else {
            echo json_encode(["error" => "Registrasi gagal. Silakan coba lagi"]);
        }

        // Tutup statement dan koneksi
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["error" => "Gagal mengunggah dokumen"]);
    }
} else {
    // Jika tidak ada data POST, arahkan ke halaman registrasi
    header("Location: ../view/registrasi_pendakwah.php");
    exit();
}
?>
