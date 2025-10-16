<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: ../index.html");
    exit();
}?>
<?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>
    <a href="./admin.php" class="block text-white">Admin</a>
<?php endif; ?>



<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DashSphere | Project Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gray-900 min-h-screen font-['Poppins'] font-serif">


    <!-- Top Navbar -->
    <header class="bg-gray-800 text-white p-4 flex justify-between items-center border-b border-gray-700">
        <h1 class="text-xl font-bold">DashSphere</h1>
        <button id="menu-btn" class="block lg:hidden text-white p-2 rounded hover:bg-gray-700 focus:outline-none" aria-label="Toggle Menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <!-- Main Layout -->
    <div class="flex">


        <!-- Left Sidebar -->
        <nav id="sidebar" class="bg-gray-800 w-60 min-h-screen p-6 space-y-6 border-r border-gray-700 hidden lg:block">
            <a href="#" class="block text-white font-bold px-4 py-2 rounded bg-gray-400 bg-opacity-30 hover:bg-gray-300 hover:text-gray-900 transition">User</a>
            <a href="./admin.php" class="block text-white">Admin</a>
            <a href="./upload.php" class="block text-white">How to Upload?</a>
            <a href="./project.php" class="block text-white">Projects</a>
            <a href="../logout.php" class="block text-white flex items-center gap-2">
                Log out
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                </svg>
            </a>
        </nav>


        <!-- Main Content -->
        <main class="flex-1 p-6 text-white">
            <!-- Announcement Section -->
            <div class="w-full h-auto bg-gray-800 rounded-lg border border-gray-600 p-4">
                <h2 class="text-3xl font-semibold mb-4">Announcements</h2>
                <?php
                $conn = new mysqli("localhost", "root", "", "test");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT * FROM announcements ORDER BY created_at DESC";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="bg-blue-900 rounded p-4 mb-4 border-l-4 border-blue-500 shadow">';
                        echo '<div class="font-bold text-blue-200 text-lg mb-1">' . htmlspecialchars($row["title"]) . '</div>';
                        echo '<div class="text-white">' . nl2br(htmlspecialchars($row["detail"])) . '</div>';
                        echo '<div class="text-xs text-blue-300 mt-1">' . date("d M Y, H:i", strtotime($row["created_at"])) . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-blue-300">No announcements yet.</p>';
                }
                $conn->close();
                ?>
            </div>


            <!-- User Info -->
            <div class="mt-6 p-4 bg-gray-800 rounded-lg border border-gray-600">
                <p class="text-lg font-bold">Logged in as:</p>
                <p class="text-sm text-gray-300">👤 Full Name: <?php echo $_SESSION['user_name']; ?></p>
                <p class="text-sm text-gray-300">📧 Email ID: <?php echo $_SESSION['user_email']; ?></p>
            </div>
        </main>

    </div>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        function showPopup(message, type) {
            const alertBox = document.createElement("div");
            alertBox.innerText = message;
            alertBox.className = `fixed top-5 right-5 px-4 py-3 rounded-lg shadow-lg text-white text-sm z-50 ${type === "success" ? "bg-green-500" : "bg-red-500"}`;
            document.body.appendChild(alertBox);
            setTimeout(() => { alertBox.remove(); }, 2000);
        }


        // Check URL for status and msg query parameters
        const params = new URLSearchParams(window.location.search);


        // Handle registration status with only status parameter
        if (params.has("status") && !params.has("msg")) {
            const status = params.get("status");
            switch (status) {
            case "registered":
                showPopup("✅ Registration successful! Please login.", "success");
                break;
            case "password_mismatch":
                showPopup("❌ Passwords do not match!", "error");
                break;
            case "email_exists":
                showPopup("❌ Email already exists!", "error");
                break;
            case "error":
                showPopup("⚠️ Something went wrong. Try again.", "error");
                break;
            }
        }


        // Handle login status with both status and msg parameters
        if (params.has("status") && params.has("msg")) {
            const status = params.get("status");
            const msg = decodeURIComponent(params.get("msg"));
            if (status === "success") {
            showPopup("✅ " + msg, "success");
            } else {
            showPopup("❌ " + msg, "error");
            }
        }


        // Clean URL to remove query parameters for better user experience
        if (params.has("status")) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>


</body>


</html>