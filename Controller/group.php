<?php
require 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $groupId = $_GET['group_id'] ?? 0;

    $stmt = $conn->prepare("SELECT messages.*, users.username 
                            FROM group_messages messages
                            JOIN users ON messages.user_id = users.id
                            WHERE messages.group_id = ?
                            ORDER BY messages.created_at ASC");
    $stmt->bind_param("i", intval($groupId));
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($messages);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $groupId = $_POST['group_id'];
    $userId = $_POST['user_id'];
    $message = $_POST['message'];

    if (empty($groupId) || empty($userId) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO group_messages (group_id, user_id, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", intval($groupId), intval($userId), $message);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
}

$conn->close();
?>
