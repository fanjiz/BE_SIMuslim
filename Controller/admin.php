<?php
// Mengimpor koneksi database
require 'config.php';

header('Content-Type: application/json');

// Pilihan data yang diambil berdasarkan parameter
$dataType = $_GET['type'] ?? null;

if ($dataType === 'pendakwah') {
    $query = "SELECT id, nama, email, sertifikasi, created_at FROM pendakwah";
} elseif ($dataType === 'peserta') {
    $query = "SELECT id, nama, email, created_at FROM peserta";
} elseif ($dataType === 'materi') {
    $query = "SELECT * FROM materi";
} else {
    http_response_code(400);
    echo json_encode(["error" => "Parameter 'type' tidak valid"]);
    exit();
}

$result = $conn->query($query);

if ($result) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Gagal mengambil data"]);
}

// Menutup koneksi
closeConnection();
?>
