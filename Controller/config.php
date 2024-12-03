<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "simuslim";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi database gagal"]);
    exit();
}

// Mengatur charset untuk koneksi
$conn->set_charset("utf8");

// Menutup koneksi secara otomatis jika tidak diperlukan lagi
function closeConnection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}
?>
