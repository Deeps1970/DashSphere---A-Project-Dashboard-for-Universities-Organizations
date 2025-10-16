<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "test";

// Database connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$name             = trim($_POST['name']);
$email            = trim($_POST['email']);
$password         = $_POST['password'];
$confirm_password = $_POST['conregpass'];

// Check if passwords match
if ($password !== $confirm_password) {
    header("Location: register.html?status=password_mismatch");
    exit();
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$sql  = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header("Location: register.html?status=error");
    exit();
}

$stmt->bind_param("sss", $name, $email, $hashedPassword);

if ($stmt->execute()) {
    // Success → redirect to login with registered popup
    header("Location: register.html?status=registered");
    exit();
} else {
    // Handle duplicate email
    if (strpos($stmt->error, "Duplicate") !== false) {
        header("Location: register.html?status=email_exists");
    } else {
        header("Location: register.html?status=error");
    }
    exit();
}

$stmt->close();
$conn->close();
?>