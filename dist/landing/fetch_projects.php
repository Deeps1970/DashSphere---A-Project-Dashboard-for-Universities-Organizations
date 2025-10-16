<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "test";

$role = isset($role) ? $role : 'student';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM projects ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Outer responsive div for mobile/tablet layout
        echo '<div class="w-full mb-6">';
        echo '<div class="w-full min-h-[220px] rounded-lg border border-gray-200 bg-gray-800 shadow p-4 sm:p-6 flex flex-col transition hover:shadow-lg">';
        echo '<div class="flex items-baseline justify-between mb-2">';
        echo '<h2 class="text-2xl font-bold tracking-tight text-white">' . htmlspecialchars($row["title"]) . '</h2>';
        echo '<span class="text-sm text-gray-400">' . htmlspecialchars($row["team_name"]) . '</span>';
        echo '</div>';
        echo '<p class="mb-3 text-white">' . htmlspecialchars($row["description"]) . '</p>';
        echo '<div class="flex flex-wrap gap-2 mb-2">';
        foreach (explode(',', $row["tech_stacks"]) as $stack) {
            echo '<span class="px-3 py-1 rounded bg-gray-400 text-white text-xs font-semibold">'
                . htmlspecialchars(trim($stack)) . '</span>';
        }
        echo '</div>';

        if ($role === 'student') {
            echo '<div class="flex justify-between items-start w-full">';
            echo '<div>';
            echo '<p class="text-white font-semibold mb-1">Team Leader: ' . htmlspecialchars($row["team_leader"]) . '</p>';
            echo '<p class="text-white font-semibold mb-2">Repository: <a href="'
                . htmlspecialchars($row["repo_link"]) . '" target="_blank" class="text-blue-400 underline">'
                . htmlspecialchars($row["repo_link"]) . '</a></p>';
            
            // ---- Live Demo section added below repo link ----
            echo '<p class="font-semibold mb-2 text-white">Live Demo: ';
            if (!empty($row["live_demo"])) {
                echo '<a href="' . htmlspecialchars($row["live_demo"]) . '" target="_blank" class="text-green-400 underline">' . htmlspecialchars($row["live_demo"]) . '</a>';
            } else {
                echo '<span class="text-gray-400">N/A</span>';
            }
            echo '</p>';
            // -----------------------------------------------
            
            echo '</div>';
            echo '<div class="text-right ml-auto">';
            if (!empty($row["remarks"])) {
                echo '<p class="italic text-yellow-400 text-sm mb-1">‘' . htmlspecialchars($row["remarks"]) . '’</p>';
            }
            if (!empty($row["rating"])) {
                echo '<span class="inline-block text-lg text-blue-400 font-bold">';
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= (int)$row["rating"] ? "★" : "☆";
                }
                echo '</span>';
            }
            echo '</div>';
            echo '</div>';
        }

        if ($role === 'admin') {
            echo '<div class="flex justify-end mt-4">';
            echo '<button class="rounded-lg bg-blue-700 px-4 py-2 text-sm text-white hover:bg-blue-800 transition" ';
            echo 'onclick="openModal('
                . '\'' . htmlspecialchars(addslashes($row["title"])) . '\','
                . '\'' . htmlspecialchars(addslashes($row["team_name"])) . '\','
                . '\'' . htmlspecialchars(addslashes($row["description"])) . '\','
                . '\'' . htmlspecialchars(addslashes($row["tech_stacks"])) . '\','
                . '\'' . htmlspecialchars(addslashes($row["team_leader"])) . '\','
                . '\'' . htmlspecialchars(addslashes($row["repo_link"])) . '\','
                . $row["id"] .
                ')">View</button>';
            echo '</div>';
        }
        echo '</div>'; // close card
        echo '</div>'; // close outer wrapper
    }
}
$conn->close();
?>

<script>
    // Popup for project added success
    const params = new URLSearchParams(window.location.search);
    if (params.has("status") && params.get("status") === "project_added") {
        showPopup("✅ Project added successfully!", "success");
        window.history.replaceState({}, document.title, window.location.pathname);
    }
</script>