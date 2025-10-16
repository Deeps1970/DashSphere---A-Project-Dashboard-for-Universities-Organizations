<?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>
    <a href="./admin.php" class="block text-white">Admin</a>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashSphere | Project Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen font-['Poppins'] font-serif ">

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
            <a href="./user.php" class="block text-white">User</a>
            <a href="./admin.php" class="block text-white">Admin</a>
            <a href="#" class="block text-white font-bold px-4 py-2 rounded bg-gray-400 bg-opacity-30 hover:bg-gray-300 hover:text-gray-900 transition">How to Upload?</a>
            <a href="./project.php" class="block text-white">Projects</a>
            <a href="../logout.php" class="block text-white flex items-center gap-2">
                Log out 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                </svg>
            </a>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 text-white">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/LXZw4tM9l0A" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen  class="w-[100%] h-[60%] border-2 border-white rounded"></iframe>
        </main>

    </div>

    <!-- Hamburger functionality -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    </script>

</body>
</html>