<?php
require 'config.php';

// Fungsi untuk mengirim pesan ke grup tertentu
function sendMessage($conn, $group_id, $username, $message) {
    $stmt = $conn->prepare("INSERT INTO chat (group_id, username, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $group_id, $username, $message);

    if ($stmt->execute()) {
        return ["status" => "success"];
    } else {
        return ["status" => "error", "error" => $stmt->error];
    }
}

// Fungsi untuk mengambil pesan dari grup tertentu
function fetchMessages($conn, $group_id) {
    $stmt = $conn->prepare("SELECT username, message, created_at FROM chat WHERE group_id = ? ORDER BY created_at ASC");
    $stmt->bind_param("i", $group_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    return $messages;
}

// Handle request POST untuk mengirim pesan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_id = $_POST['group_id'];
    $username = $_POST['username'];
    $message = $_POST['message'];

    $response = sendMessage($conn, $group_id, $username, $message);
    echo json_encode($response);
}

// Handle request GET untuk mengambil pesan
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['group_id'])) {
        $group_id = $_GET['group_id'];
        $messages = fetchMessages($conn, $group_id);
        echo json_encode($messages);
    } else {
        echo json_encode(["status" => "error", "error" => "group_id not provided"]);
    }
}

// Tutup koneksi
$conn->close();
?>
