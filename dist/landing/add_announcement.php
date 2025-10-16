<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db   = "test";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$title = trim($_POST['title']);
$detail = trim($_POST['detail']);

// Fixed typo in column name
$sql = "INSERT INTO announcements (title, detail) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $title, $detail);

if ($stmt->execute()) {
    // Status param triggers popup in admin.php
    header("Location: admin.php?status=announcement_added");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>