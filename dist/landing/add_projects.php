<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: ../index.html");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "test";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize form values
$title       = trim($_POST['title']);
$teamName    = trim($_POST['teamName']);
$description = trim($_POST['description']);
$techStacks  = trim($_POST['techStacks']);
$teamLeader  = trim($_POST['teamLeader']);
$repoLink    = trim($_POST['repoLink']);
$liveDemo = isset($_POST['liveDemo']) ? trim($_POST['liveDemo']) : '';

$sql = "INSERT INTO projects (title, team_name, description, tech_stacks, team_leader, repo_link, live_demo)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $title, $teamName, $description, $techStacks, $teamLeader, $repoLink, $liveDemo);

f ($stmt->execute()) {
    // Add status for successful popup on project.php
    header("Location: project.php?status=project_added");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>