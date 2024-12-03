<?php

include('config.php');

// Tangani permintaan
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Cek apakah ada parameter pencarian
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

    // Query data
    $query = "SELECT * FROM materi";
    if (!empty($search)) {
        $query .= " WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
    }

    $result = $conn->query($query);

    if ($result) {
        $materi = [];
        while ($row = $result->fetch_assoc()) {
            $materi[] = $row;
        }
        echo json_encode($materi);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Gagal mengambil data"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Metode tidak diizinkan"]);
}

$conn->close();
