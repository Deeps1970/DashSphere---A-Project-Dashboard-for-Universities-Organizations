<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db   = "test";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if (empty($email) || empty($password)) {
        header("Location: index.html?status=error&msg=" . urlencode("Email or password is empty"));
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['is_admin'] = (int) $user['admin'];  // Store admin flag in session
            header("Location: landing/user.php?status=success&msg=" . urlencode("Login successful, Welcome Back!"));
            exit();
        }
        else {
            header("Location: index.html?status=error&msg=" . urlencode("Incorrect password, Retry!"));
            exit;
        }
    } else {
        header("Location: index.html?status=error&msg=" . urlencode("Email not found!"));
        exit;
    }
    $stmt->close();
    $conn->close();
}
?>
