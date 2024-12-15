<?php
session_start();
include_once 'config.php'; // Sertakan koneksi database

// Fungsi untuk validasi email
function isEmailRegistered($email, $conn) {
    $stmt = $conn->prepare("SELECT * FROM pendakwah WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Validasi file
function isValidFile($file) {
    $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($file['size'] > 5242880) { // Validasi ukuran file max 5MB
        return ["error" => "Ukuran file tidak boleh lebih dari 5MB"];
    }

    if (!in_array($fileExtension, $allowedTypes)) {
        return ["error" => "Hanya file PDF, JPG, JPEG, atau PNG yang diperbolehkan"];
    }

    return true;
}

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $dokumen = $_FILES['dokumen'];

    // Cek apakah email sudah digunakan
    if (isEmailRegistered($email, $conn)) {
        header("Location: ../view/registrasi_pendakwah.php?error=email_exists");
        exit();
    }

    // Validasi file
    $fileValidation = isValidFile($dokumen);
    if ($fileValidation !== true) {
        echo json_encode($fileValidation);
        exit();
    }

    $targetDir = "../uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $uniqueFileName = uniqid() . '.' . strtolower(pathinfo($dokumen['name'], PATHINFO_EXTENSION));
    $targetFilePath = $targetDir . $uniqueFileName;

    if (move_uploaded_file($dokumen['tmp_name'], $targetFilePath)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk memasukkan data ke database
        $stmt = $conn->prepare("INSERT INTO pendakwah (username, nama_lengkap, email, password, uploaded_file, file_size) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $username, $nama_lengkap, $email, $hashedPassword, $uniqueFileName, $dokumen['size']);

        if ($stmt->execute()) {
            header("Location: ../view/halaman_tunggu.html");
            exit();
        } else {
            echo json_encode(["error" => "Gagal melakukan registrasi. Silakan coba lagi."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Gagal mengunggah dokumen."]);
    }

    $conn->close();
} else {
    header("Location: ../view/registrasi_pendakwah.php");
    exit();
}
?>
