<?php
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $groupId = $_GET['groupId'] ?? 0;

    if ($groupId > 0) {
        $stmt = $conn->prepare("SELECT username, message, created_at FROM chat WHERE group_id = ? ORDER BY created_at ASC");
        $stmt->bind_param("i", $groupId);
        $stmt->execute();
        $result = $stmt->get_result();
        $messages = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($messages);
    } else {
        echo json_encode([]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $groupId = $_POST['groupId'] ?? 0;
    $username = $_POST['username'] ?? '';
    $message = $_POST['message'] ?? '';

    if ($groupId > 0 && !empty($username) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO chat (group_id, username, message, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $groupId, $username, $message);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input"]);
    }
}

$conn->close();
?>
