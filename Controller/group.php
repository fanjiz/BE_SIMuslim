<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $ustadz_name = $_POST['ustadz_name'] ?? '';
    $profile_picture = 'default.jpg'; // Default profile picture

    if (!empty($title) && !empty($ustadz_name)) {
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/'; // Absolute path to the uploads directory
            $fileName = uniqid() . '-' . basename($_FILES['profile_picture']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
                $profile_picture = $fileName;
            } else {
                echo json_encode(["status" => "error", "error" => "Failed to upload profile picture"]);
                exit;
            }
        }

        $stmt = $conn->prepare("INSERT INTO groups (title, ustadz_name, profile_picture) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $ustadz_name, $profile_picture);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "error" => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "error" => "Invalid input"]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM groups ORDER BY created_at DESC");
    $groups = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($groups);
}

$conn->close();
?>
