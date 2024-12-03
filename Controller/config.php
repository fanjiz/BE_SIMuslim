<?php

header("Content-Type: application/json");

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "simuslim";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi database gagal"]);
    exit();
}

?>