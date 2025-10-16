<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "test";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

// Sanitize input
$project_id = intval($_POST['project_id'] ?? 0);
$remarks = trim($_POST['remarks'] ?? '');
$rating = intval($_POST['rating'] ?? 0);

$sql = "UPDATE projects SET remarks = ?, rating = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $remarks, $rating, $project_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Review saved!']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>