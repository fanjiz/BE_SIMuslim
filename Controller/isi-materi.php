<?php
include('config.php');  // Include the database connection

// Check if it's a GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get search parameter from the query string (if any)
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

    // Define the SQL query
    $query = "SELECT * FROM isi-materi";
    if (!empty($search)) {
        $query .= " WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
    }

    // Execute the query
    $result = $conn->query($query);

    // Check if the query was successful
    if ($result) {
        $materi = [];
        // Fetch all results
        while ($row = $result->fetch_assoc()) {
            $materi[] = $row;
        }
        // Return results as JSON
        echo json_encode($materi);
    } else {
        // Return error response if query fails
        http_response_code(500);
        echo json_encode(["error" => "Failed to fetch data"]);
    }
} else {
    // Return error if method is not GET
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}

// Close the database connection
$conn->close();
