<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    // Redirect non-admin users to user dashboard or login page
    header("Location: user.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashSphere | Admin Dashboard</title>
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

    <div class="flex">
        <!-- Left Sidebar -->
        <nav id="sidebar" class="bg-gray-800 w-60 min-h-screen p-6 space-y-6 border-r border-gray-700 hidden lg:block">
            <a href="./user.php" class="block text-white">User</a>
            <a href="#" class="block text-white font-bold px-4 py-2 rounded bg-gray-400 bg-opacity-30 hover:bg-gray-300 hover:text-gray-900 transition">Admin</a>
            <a href="./upload.php" class="block text-white">How to Upload?</a>
            <a href="./project.php" class="block text-white">Projects</a>
            <a href="../logout.php" class="block text-white flex items-center gap-2">
                Log out 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                </svg>
            </a>
        </nav>
        <main class="w-full p-8">
            <div class="flex justify-end mb-6">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="openAnnouncementModal()">
                    Add New Announcement
                </button>
            </div>
            <?php $role = 'admin'; include 'fetch_projects.php'; ?>
        </main>
    </div>

    <!-- Announcement Modal -->
    <div id="announcementModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8 w-full max-w-xl border border-gray-300">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">Add Announcement</h3>
                <button onclick="closeAnnouncementModal()" class="text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <form action="add_announcement.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-white font-semibold mb-1">Announcement Title</label>
                    <input type="text" name="title" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600">
                </div>
                <div>
                    <label class="block text-white font-semibold mb-1">Announcement Detail</label>
                    <textarea name="detail" rows="3" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600"></textarea>
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Announce
                </button>
            </form>
        </div>
    </div>
    <!-- Existing Project Modal -->
    <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8 w-full max-w-xl border border-gray-300">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white" id="modalTitle">Project Details</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <div>
                <input type="hidden" id="projectIdForModal">
                <p class="mb-2 text-white font-bold">Title: <span id="modalProjectTitle"></span></p>
                <p class="mb-2 text-white font-bold">Team Name: <span id="modalTeamName"></span></p>
                <p class="mb-2 text-white">Short Description: <span id="modalDescription"></span></p>
                <p class="mb-2 text-white font-bold">Tech Stacks: <span id="modalTechStacks"></span></p>
                <p class="mb-2 text-white font-bold">Team Leader: <span id="modalTeamLeader"></span></p>
                <p class="mb-2 text-white font-bold">Repository: <a id="modalRepoLink" href="#" target="_blank" class="text-blue-400 underline"></a></p>
                <label class="text-white block mb-2 mt-4">Remarks:</label>
                <textarea id="adminRemarks" class="w-full mb-4 p-2 rounded bg-gray-700 text-white border border-gray-600"
                    rows="2" placeholder="Add remarks..."></textarea>
                <label class="text-white block mb-2">Rating:</label>
                <select id="adminRating" class="w-full p-2 rounded mb-4 bg-gray-700 text-white border border-gray-600">
                    <option value="">Select Rating</option>
                    <option value="1">&#9733;</option>
                    <option value="2">&#9733;&#9733;</option>
                    <option value="3">&#9733;&#9733;&#9733;</option>
                    <option value="4">&#9733;&#9733;&#9733;&#9733;</option>
                    <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                </select>
                <button class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-white font-semibold" onclick="saveReview()">Save</button>
            </div>
        </div>
    </div>
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        function openAnnouncementModal() {
            document.getElementById('announcementModal').classList.remove('hidden');
        }
        function closeAnnouncementModal() {
            document.getElementById('announcementModal').classList.add('hidden');
        }
        function openModal(title, teamName, description, techStacks, teamLeader, repoLink, projectId) {
            document.getElementById('modalProjectTitle').textContent = title;
            document.getElementById('modalTeamName').textContent = teamName;
            document.getElementById('modalDescription').textContent = description;
            document.getElementById('modalTechStacks').textContent = techStacks;
            document.getElementById('modalTeamLeader').textContent = teamLeader;
            document.getElementById('modalRepoLink').textContent = repoLink;
            document.getElementById('modalRepoLink').href = repoLink;
            document.getElementById('projectIdForModal').value = projectId;
            document.getElementById('viewModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }
        function saveReview() {
            const remarks = document.getElementById('adminRemarks').value;
            const rating = document.getElementById('adminRating').value;
            const projectId = document.getElementById('projectIdForModal').value;
            fetch('save_review.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'project_id=' + encodeURIComponent(projectId) +
                      '&remarks=' + encodeURIComponent(remarks) +
                      '&rating=' + encodeURIComponent(rating)
            })
            .then(response => response.text())
            .then(msg => alert(msg));
        }
    </script>
</body>
</html>
