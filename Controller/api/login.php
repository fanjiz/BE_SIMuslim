<?php
// login.php

// Include database configuration
include_once('../config.php');

// Set header for JSON response
header('Content-Type: application/json');

// Get the data from the POST request
$data = json_decode(file_get_contents("php://input"));

// Validate data
if (isset($data->username) && isset($data->password)) {
    $username = $data->username;
    $password = $data->password;

    // Create database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check if connection was successful
    if ($conn->connect_error) {
        die(json_encode(["success" => false, "message" => "Connection failed"]));
    }

    // Prepare SQL query to fetch user data
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Return success if password is correct
            echo json_encode(["success" => true]);
        } else {
            // Return failure if password is incorrect
            echo json_encode(["success" => false, "message" => "Invalid credentials"]);
        }
    } else {
        // Return failure if username doesn't exist
        echo json_encode(["success" => false, "message" => "User not found"]);
    }

    // Close database connection
    $conn->close();
} else {
    // Return error if data is incomplete
    echo json_encode(["success" => false, "message" => "Invalid request data"]);
}
?>
