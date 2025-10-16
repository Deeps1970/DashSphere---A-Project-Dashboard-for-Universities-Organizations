<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: ../index.html");
    exit();
}
?>
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
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <!-- Main Layout -->
    <div class="flex">

        <!-- Left Sidebar -->
        <nav id="sidebar" class="bg-gray-800 w-60 min-h-screen p-6 space-y-6 border-r border-gray-700 hidden lg:block">
            <a href="./user.php" class="block text-white">User</a>
            <a href="./admin.php" class="block text-white">Admin</a>
            <a href="./upload.php" class="block text-white">How to Upload?</a>
            <a href="#" class="block text-white font-bold px-4 py-2 rounded bg-gray-400 bg-opacity-30 hover:bg-gray-300 hover:text-gray-900 transition">Projects</a>
            <a href="../logout.php" class="block text-white flex items-center gap-2">
                Log out 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                </svg>
            </a>
        </nav>

        <!-- Main Content -->
        <main class="flex flex-col gap-2 items-end p-6 text-white w-full">
            <div class="flex justify-end w-full mb-4">
                <button 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    onclick="openProjectModal()"
                >
                    Add Projects
                </button>
            </div>

            <?php include 'fetch_projects.php'; ?>
        </main>
    </div>

    <!-- Modal for Adding Project -->
    <div id="projectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8 w-full max-w-xl border border-gray-300">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">Upload New Project</h3>
                <button onclick="closeProjectModal()" class="text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <form action="add_projects.php" method="POST" class="space-y-4">
                <div>
                    <label for="title" class="block text-white font-semibold mb-1">Title of the Project</label>
                    <input type="text" id="title" name="title" placeholder="Title of the project" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600">
                </div>
                <div>
                    <label for="teamName" class="block text-white font-semibold mb-1">Team Name</label>
                    <input type="text" id="teamName" name="teamName" placeholder="e.g. TechThrive" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600">
                </div>
                <div>
                    <label for="description" class="block text-white font-semibold mb-1">Short Description</label>
                    <textarea id="description" name="description" rows="2" placeholder="Yap Shortly..." required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600"></textarea>
                </div>
                <div>
                    <label for="techStacks" class="block text-white font-semibold mb-1">Tech Stacks Used</label>
                    <input type="text" id="techStacks" name="techStacks" placeholder="HTML, CSS, JS, Python, etc." required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600">
                </div>
                <div>
                    <label for="teamLeader" class="block text-white font-semibold mb-1">Team Leader's Name</label>
                    <input type="text" id="teamLeader" name="teamLeader" placeholder="e.g. Deepak.B.T" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600">
                </div>
                <div>
                    <label for="repoLink" class="block text-white font-semibold mb-1">Repository Link (GitHub/Drive)</label>
                    <input type="url" id="repoLink" name="repoLink" placeholder="https://yourrepo.demo" required class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600">
                </div>
                <div>
                    <label for="liveDemo" class="block text-white font-semibold mb-1">Deployement Link (YouTube/App)</label>
                    <input type="url" id="liveDemo" name="liveDemo" placeholder="https://yourapp.demo (optional)" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit Project
                </button>
            </form>
        </div>
    </div>

    <!-- Popup Modal for Viewing Project Details (student view, no remark/rating) -->
    <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
        <div class="bg-gray-800 rounded-lg shadow-lg p-8 w-full max-w-xl border border-gray-300">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white" id="modalTitle">Project Details</h3>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <div>
                <p class="mb-2 text-white font-bold">Title: <span id="modalProjectTitle"></span></p>
                <p class="mb-2 text-white font-bold">Team Name: <span id="modalTeamName"></span></p>
                <p class="mb-2 text-white">Short Description: <span id="modalDescription"></span></p>
                <p class="mb-2 text-white font-bold">Tech Stacks: <span id="modalTechStacks"></span></p>
                <p class="mb-2 text-white font-bold">Team Leader: <span id="modalTeamLeader"></span></p>
                <p class="mb-2 text-white font-bold">Repository: <a id="modalRepoLink" href="#" target="_blank" class="text-blue-400 underline"></a></p>
            </div>
        </div>
    </div>

    <script>
        // Hamburger for mobile
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        function openProjectModal() {
            document.getElementById('projectModal').classList.remove('hidden');
        }
        function closeProjectModal() {
            document.getElementById('projectModal').classList.add('hidden');
        }
        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }
        function openViewModal(title, teamName, description, techStacks, teamLeader, repoLink) {
            document.getElementById('modalProjectTitle').textContent = title;
            document.getElementById('modalTeamName').textContent = teamName;
            document.getElementById('modalDescription').textContent = description;
            document.getElementById('modalTechStacks').textContent = techStacks;
            document.getElementById('modalTeamLeader').textContent = teamLeader;
            document.getElementById('modalRepoLink').textContent = repoLink;
            document.getElementById('modalRepoLink').href = repoLink;
            document.getElementById('viewModal').classList.remove('hidden');
        }
    </script>
</body>
</html>