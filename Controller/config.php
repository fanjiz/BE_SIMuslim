<?php
// Koneksi ke database menggunakan MySQLi
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "simuslim";

// Membuat koneksi MySQLi
$conn = new mysqli($host, $user, $pass, $dbname);

// Mengecek koneksi MySQLi
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi database gagal"]);
    exit();
}

// Mengatur charset untuk koneksi MySQLi
$conn->set_charset("utf8");

// Fungsi untuk menutup koneksi MySQLi secara otomatis
function closeConnection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}

// Koneksi ke database menggunakan PDO
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi database PDO gagal: " . $e->getMessage()]);
    exit();
}
?>
