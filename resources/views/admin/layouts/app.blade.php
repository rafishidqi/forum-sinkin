<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Forum Sinkin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('fonts/poppins.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes gradientMovement {
            0% {
                background-position: 100% 0;
            }
            50% {
                background-position: 0 100%;
            }
            100% {
                background-position: 100% 0;
            }
        }

        .gradient-text {
            background: linear-gradient(45deg, #3b82f6, #9333ea);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            color: transparent;
            /* MODIFIED: Removed 'infinite', added 'forwards' */
            animation: gradientMovement 5s linear forwards; 
        }

        /* NEW: Class to temporarily disable transitions */
        .no-transition {
            transition: none !important;
        }

        /* Sidebar expanded and collapsed styles */
        .sidebar-expanded {
            width: 16rem; /* Expanded width */
            padding-left: 2rem;
            padding-right: 2rem;
            transition: width 0.3s ease-in-out, padding 0.3s ease-in-out;
        }

        .sidebar-collapsed {
            width: 5rem; /* Shrunken width */
            padding-left: 0; /* Remove horizontal padding here */
            padding-right: 0; /* Remove horizontal padding here */
            transition: width 0.3s ease-in-out, padding 0.3s ease-in-out;
        }

        .sidebar-icon {
            font-size: 1.6rem; /* Increased icon size */
            transition: transform 0.3s ease; /* Smooth scale effect */
            display: flex; /* Use flexbox for centering */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            min-width: 2.5rem; /* Ensure minimum width for icon */
            height: 2.5rem; /* Fixed height for icon container */
        }

        /* Ensure icon takes full width in collapsed state for centering */
        .sidebar-collapsed .sidebar-icon {
            width: 100%; /* Take full width of the parent link */
            margin-left: 0; /* No margin on icon itself */
            margin-right: 0;
        }

        .sidebar-text {
            margin-left: 1rem; /* Add space between icon and text */
            opacity: 1;
            white-space: nowrap; /* Prevent text wrapping */
            overflow: hidden; /* Hide overflow content */
            transition: opacity 0.3s ease, margin-left 0.3s ease, width 0.3s ease;
            width: auto; /* Default auto width */
        }

        /* Custom styling for hiding text on collapse */
        .sidebar-collapsed .sidebar-text {
            opacity: 0;
            width: 0; /* Collapse width to hide text */
            margin-left: 0;
            pointer-events: none; /* Prevent interaction with hidden text */
        }

        /* Sidebar item padding */
        .sidebar ul li {
            margin: 0 0 10px 0; /* Adjusted bottom margin between items */
        }

        /* Hover Effect */
        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 16px; /* Default padding for expanded state */
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            color: gray;
            position: relative; 
            overflow: hidden; 
        }

        /* Adjusted padding for collapsed state to make icons centered within the 5rem width */
        .sidebar-collapsed a {
            justify-content: center; /* Center content in collapsed state */
            padding: 12px 0; /* Only vertical padding */
        }

        .sidebar a:hover {
            background: radial-gradient(circle at center, #2563eb 0%, #1a4f9e 100%); /* Radial gradient for hover */
            transform: translateY(-2px); /* Slight lift effect */
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Subtle shadow on hover */
        }

        /* NEW: Custom Tooltip CSS controlled by JavaScript */
        #custom-tooltip {
            position: fixed; 
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            white-space: nowrap;
            pointer-events: none; 
            opacity: 0; 
            visibility: hidden; 
            transition: opacity 0.2s ease, visibility 0.2s ease; 
            z-index: 1000; 
        }

        /* Adjust content layout to follow sidebar width */
        main {
            margin-left: 16rem; /* Default margin for expanded sidebar */
            transition: margin-left 0.3s ease;
        }

        .sidebar-collapsed ~ main {
            margin-left: 5rem; /* Match sidebar collapsed width */
        }

        /* Sidebar Header Layout */
        .sidebar-header {
            display: flex;
            justify-content: space-between; 
            align-items: center;
            width: 100%;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            flex: 2;
            margin: 0;
            line-height: 1.2;
        }

        .sidebar-header button {
            display: flex;
            justify-content: center; 
            align-items: center; 
            flex: 1; 
            padding: 0.5rem;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease, opacity 0.3s ease;
            color: white;
        }

        .sidebar-header button:hover {
            opacity: 0.8;
            transform: scale(1.1);
        }

        .sidebar-collapsed .sidebar-header {
            justify-content: center; 
            padding-right: 0;
            padding-left: 0;
        }

        .sidebar-collapsed .sidebar-header h2 {
            display: none; 
        }

        .sidebar-collapsed .sidebar-header button {
            flex: none; 
            width: 100%; 
        }

        /* Active link style */
        .sidebar a.active {
            background: radial-gradient(circle at center, #2563eb 0%, #1a4f9e 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                left: -16rem;
                height: 100%;
                z-index: 1000;
                width: 16rem;
                padding-left: 2rem;
                padding-right: 2rem;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            }

            #sidebar.sidebar-expanded {
                left: 0;
            }

            #sidebar.sidebar-collapsed {
                 left: -16rem;
                 width: 16rem;
            }

            main {
                margin-left: 0;
            }

            .sidebar-collapsed ~ main {
                margin-left: 0;
            }

            .sidebar-header h2 {
                font-size: 1.25rem;
            }

            .sidebar-header button {
                font-size: 1.5rem;
                display: flex; 
                justify-content: center; 
                align-items: center; 
                flex: none; 
                width: 100%; 
            }
        }
    </style>
</head>
<body class="flex bg-gray-900 text-gray-200 min-h-screen font-poppins">

    <aside id="sidebar" class="w-64 bg-gray-800 shadow-md h-screen p-6 fixed top-0 left-0 bottom-0 sidebar-expanded no-transition">
        
        <div class="sidebar-header">
            <h2 class="text-2xl font-semibold sidebar-text">
                <span class="gradient-text font-semibold">Sink</span><span class="gradient-text font-semibold">In</span> <br> <span class="text-lg font-light text-gray-400">Admin Panel</span>
            </h2>
            <button id="toggleSidebar" class="text-white">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    
        <ul class="space-y-3 text-sm">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="block text-gray-300 {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt sidebar-icon"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="block text-gray-300 {{ Request::routeIs('categories.index') ? 'active' : '' }}" data-tooltip="Kategori">
                    <div class="flex items-center">
                        <i class="fas fa-th-list sidebar-icon"></i>
                        <span class="sidebar-text">Kategori</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.posts.index') }}" class="block text-gray-300 {{ Request::routeIs('admin.posts.index') ? 'active' : '' }}" data-tooltip="Postingan">
                    <div class="flex items-center">
                        <i class="fas fa-newspaper sidebar-icon"></i>
                        <span class="sidebar-text">Postingan</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('user.index') }}" class="block text-gray-300 {{ Request::routeIs('user.index') ? 'active' : '' }}" data-tooltip="Pengguna">
                    <div class="flex items-center">
                        <i class="fas fa-users sidebar-icon"></i>
                        <span class="sidebar-text">Pengguna</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports.index') }}" class="block text-gray-300 {{ Request::routeIs('admin.report.index') ? 'active' : '' }}" data-tooltip="Laporan Pengguna">
                    <div class="flex items-center">
                        <i class="fas fa-file-alt sidebar-icon"></i>
                        <span class="sidebar-text">Laporan</span>
                    </div>
                </a>
            </li>
            <li>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-400 hover:text-white" data-tooltip="Logout">
                        <div class="flex items-center">
                            <i class="fas fa-sign-out-alt sidebar-icon"></i>
                            <span class="sidebar-text">Logout</span>
                        </div>
                    </button>
                </form>
            </li>
        </ul>
    </aside>     

    <main class="flex-1 p-6 ml-64 overflow-y-auto bg-gray-900">
        <header class="border-b border-gray-700 pb-3 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-white">@yield('title', 'Dashboard')</h1>
            <span class="text-sm text-gray-400">Halo, {{ Auth::guard('admin')->user()->name }}</span>
        </header>

        @yield('content')
    </main>

    <div id="custom-tooltip"></div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('toggleSidebar');
        const toggleIcon = toggleButton.querySelector('i');
        const mainContent = document.querySelector('main');
        const EXPANDED_WIDTH = '16rem';
        const COLLAPSED_WIDTH = '5rem';
        const MOBILE_HIDDEN_LEFT = '-16rem';

        const SIDEBAR_STATE_KEY = 'sidebarExpanded'; // Key for localStorage

        // Function to set sidebar state
        function setSidebarState(isExpanded) {
            if (isExpanded) {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                mainContent.style.marginLeft = EXPANDED_WIDTH;
                toggleIcon.classList.remove('fa-arrow-right');
                toggleIcon.classList.add('fa-bars');
                localStorage.setItem(SIDEBAR_STATE_KEY, 'expanded'); // Save state
            } else {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                mainContent.style.marginLeft = COLLAPSED_WIDTH;
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-arrow-right');
                localStorage.setItem(SIDEBAR_STATE_KEY, 'collapsed'); // Save state
            }
        }

        // Initialize sidebar state based on screen size AND saved preference
        function initializeSidebar() {
            // First, ensure no transitions are active while we set the initial state
            sidebar.classList.add('no-transition');

            if (window.innerWidth > 768) {
                const savedState = localStorage.getItem(SIDEBAR_STATE_KEY);
                if (savedState === 'collapsed') {
                    setSidebarState(false); // Apply collapsed state if saved
                } else {
                    setSidebarState(true); // Default to expanded if no saved state or 'expanded'
                }
                sidebar.style.left = '0'; // Ensure it's visible on desktop
            } else {
                // On smaller screens, sidebar should always start hidden
                sidebar.classList.remove('sidebar-expanded'); 
                sidebar.classList.add('sidebar-collapsed'); 
                sidebar.style.left = MOBILE_HIDDEN_LEFT; 
                mainContent.style.marginLeft = '0'; 
                toggleIcon.classList.remove('fa-arrow-left');
                toggleIcon.classList.add('fa-bars'); 
                localStorage.removeItem(SIDEBAR_STATE_KEY); // Clear desktop preference on mobile
            }

            // After applying the initial state, remove 'no-transition' to enable animations for subsequent user interactions
            // Use requestAnimationFrame for better visual sync, or setTimeout(0) as fallback
            requestAnimationFrame(() => {
                sidebar.classList.remove('no-transition');
            });
            // Or if requestAnimationFrame doesn't work well in your setup:
            // setTimeout(() => {
            //     sidebar.classList.remove('no-transition');
            // }, 0); 
        }

        // Call on initial load
        initializeSidebar();

        toggleButton.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                // Mobile behavior: slide in/out
                if (sidebar.style.left === '0px' || sidebar.style.left === '0rem') { // Currently open
                    sidebar.style.left = MOBILE_HIDDEN_LEFT; // Hide
                    toggleIcon.classList.remove('fa-arrow-left');
                    toggleIcon.classList.add('fa-bars');
                } else { // Currently hidden
                    sidebar.style.left = '0'; // Show
                    toggleIcon.classList.remove('fa-bars');
                    toggleIcon.classList.add('fa-arrow-left'); // Change icon to indicate it's open
                }
            } else {
                // Desktop behavior: toggle expanded/collapsed
                const isExpanded = sidebar.classList.contains('sidebar-expanded');
                setSidebarState(!isExpanded);
            }
        });

        // Handle window resize for responsiveness
        window.addEventListener('resize', () => {
            initializeSidebar();
            hideTooltip(); // Hide tooltip on resize
        });

        // Add 'active' class to current link
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('#sidebar ul li a');

            sidebarLinks.forEach(link => {
                link.classList.remove('active'); 
                
                if (link.getAttribute('href') && currentPath.startsWith(link.getAttribute('href'))) {
                    link.classList.add('active');
                }
            });

            if (currentPath === '/admin' || currentPath === '/') {
                const dashboardLink = document.querySelector('a[href="{{ route('admin.dashboard') }}"]');
                if (dashboardLink) {
                    dashboardLink.classList.add('active');
                }
            }
        });

        // --- Custom Tooltip JavaScript (dynamic Y-position) ---
        const customTooltip = document.getElementById('custom-tooltip');

        function showTooltip(text) {
            customTooltip.textContent = text;
            customTooltip.style.opacity = '1';
            customTooltip.style.visibility = 'visible';
        }

        function hideTooltip() {
            customTooltip.style.opacity = '0';
            customTooltip.style.visibility = 'hidden';
        }

        function moveTooltip(event) {
            if (sidebar.classList.contains('sidebar-collapsed') && window.innerWidth > 768) {
                const tooltipHeight = customTooltip.offsetHeight; 
                
                const sidebarWidthPx = sidebar.offsetWidth; 
                const tooltipX = sidebarWidthPx + 10; 

                let tooltipY = event.clientY - (tooltipHeight / 2);

                if (tooltipY < 0) {
                    tooltipY = 0;
                }
                if (tooltipY + tooltipHeight > window.innerHeight) {
                    tooltipY = window.innerHeight - tooltipHeight;
                }

                customTooltip.style.left = `${tooltipX}px`;
                customTooltip.style.top = `${tooltipY}px`;
            } else {
                hideTooltip(); 
            }
        }

        const sidebarLinks = document.querySelectorAll('#sidebar ul li a');

        sidebarLinks.forEach(link => {
            const tooltipText = link.getAttribute('data-tooltip');
            if (tooltipText) { 
                link.addEventListener('mouseenter', () => { 
                    if (sidebar.classList.contains('sidebar-collapsed') && window.innerWidth > 768) {
                        showTooltip(tooltipText);
                    }
                });

                link.addEventListener('mousemove', moveTooltip); 

                link.addEventListener('mouseleave', hideTooltip); 
            }
        });

        sidebar.addEventListener('mouseleave', hideTooltip);

        toggleButton.addEventListener('click', () => {
            setTimeout(() => {
                if (!sidebar.classList.contains('sidebar-collapsed') || window.innerWidth <= 768) {
                    hideTooltip();
                }
            }, 300); 
        });

    </script>

</body>
</html>