<?php
// admin_header.php - At the very top
require_once 'admin_auth_check.php';

// Now you can use session variables in the header
$admin_name = $_SESSION['full_name'];
$admin_role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | RKU Galore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-dark: #7a0c15;
            --bg-main: #f3f5f9;
            --glass: rgba(255, 255, 255, 0.75);
        }

        body {
            background: linear-gradient(120deg, #fdfbfb, #ebedee);
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            width: 270px;
            height: 100vh;
            padding: 35px 24px;
            background: var(--glass);
            backdrop-filter: blur(14px);
            border-right: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 10px 0 40px rgba(0, 0, 0, 0.08);
            z-index: 1050;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(220, 53, 69, 0.4);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(220, 53, 69, 0.7);
        }

        /* Mobile sidebar handling */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* ===== LOGO ===== */
        .sidebar-logo {
            text-align: center;
            margin-bottom: 55px;
        }

        .sidebar-logo img {
            max-height: 55px;
            margin: 0 6px;
        }

        .sidebar-logo span {
            display: block;
            margin-top: 14px;
            font-size: 1.4rem;
            font-weight: 900;
            background: linear-gradient(to right, var(--galore-red), #ff6b6b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ===== NAV LINKS ===== */
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            margin-bottom: 14px;
            font-weight: 700;
            border-radius: 14px;
            color: var(--galore-red);
            text-decoration: none;
            transition: all 0.35s ease;
        }

        .sidebar a i {
            font-size: 1.2rem;
        }

        .sidebar a:hover {
            background: linear-gradient(to right, rgba(220, 53, 69, 0.15), transparent);
            transform: translateX(6px);
            color: var(--galore-dark);
        }

        .sidebar a.active {
            background: linear-gradient(to right, var(--galore-red), #ff6b6b);
            color: #fff;
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.4);
        }

        /* ===== DROPDOWN MENU ===== */
        .dropdown-container {
            margin-bottom: 14px;
        }

        .dropdown-toggle {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            font-weight: 700;
            border-radius: 14px;
            color: var(--galore-red);
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dropdown-toggle:hover {
            background: linear-gradient(to right, rgba(220, 53, 69, 0.15), transparent);
            transform: translateX(6px);
            color: var(--galore-dark);
        }

        .dropdown-arrow {
            transition: transform 0.3s ease;
        }

        .dropdown-container.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        /* Dropdown menu */
        .dropdown-menu-custom {
            display: none;
            margin-top: 8px;
            background: var(--glass);
            backdrop-filter: blur(14px);
            border-radius: 14px;
            padding: 10px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .dropdown-container.active .dropdown-menu-custom {
            display: block;
        }

        .dropdown-menu-custom a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            font-weight: 600;
            color: var(--galore-red);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .dropdown-menu-custom a:hover {
            background: linear-gradient(to right, rgba(220, 53, 69, 0.1), transparent);
            color: var(--galore-dark);
            border-left: 3px solid var(--galore-red);
            transform: translateX(5px);
        }

        .dropdown-menu-custom a.active {
            background: linear-gradient(to right, rgba(220, 53, 69, 0.15), transparent);
            color: var(--galore-dark);
            border-left: 3px solid var(--galore-red);
            transform: translateX(5px);
        }

        /* Mobile responsiveness for dropdown */
        @media (max-width: 991.98px) {
            .dropdown-menu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                background: rgba(255, 255, 255, 0.9);
                margin-top: 5px;
                margin-left: 20px;
                width: calc(100% - 40px);
                display: none;
                border: none;
            }

            .dropdown-container.active .dropdown-menu {
                display: block;
            }

            .dropdown-container.active .dropdown-arrow {
                transform: rotate(180deg);
            }
        }

        /* ===== MOBILE MENU BUTTON ===== */
        .menu-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1060;
            background: var(--galore-red);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .menu-btn:hover {
            transform: scale(1.05);
        }

        /* ===== SIDEBAR SCROLLBAR ===== */
        .sidebar {
            overflow-y: auto;
        }

        /* Optional: nice custom scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(220, 53, 69, 0.4);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(220, 53, 69, 0.7);
        }
    </style>
</head>

<body>
    <!-- Added id="menuToggleBtn" and removed onclick -->
    <button class="menu-btn d-lg-none" id="menuToggleBtn">
        <i class="bi bi-list"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="Website/rku_logo.png">
            <img src="Website/galore_logo.png">
            <span>RK University</span>
        </div>

        <a href="ad_c_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="ad_c_profile.php"><i class="fas fa-user-tie"></i> Profile</a>

        <!-- Dropdown Menu - Headers -->
        <div class="dropdown-container">
            <button class="dropdown-toggle" type="button">
                <span>
                    <i class="bi bi-house-add-fill"></i> Headers
                </span>
            </button>
            <div class="dropdown-menu-custom">
                <a href="ad_c_dash.php"><i class="bi bi-image-fill"></i> Dashboard Header</a>
                <a href="ad_c_sch.php"><i class="bi bi-info-circle-fill"></i> School Header</a>
                <a href="ad_c_rr.php"><i class="bi bi-trophy-fill"></i> Results Header</a>
                <a href="ad_c_part.php"><i class="bi bi-calendar2-event-fill"></i> Participations Header</a>
                <a href="ad_c_announce.php"><i class="bi bi-house-add-fill"></i> Announcements Header</a>
            </div>
        </div>

        <a href="ad_c_school.php"><i class="bi bi-image-fill"></i> Engineering</a>
        <a href="ad_c_Participations.php"><i class="bi bi-people-fill"></i> Participations</a>
        <a href="ad_c_results.php"><i class="bi bi-dice-4"></i> Results/Ranking</a>
        <a href="ad_c_announcements.php"><i class="bi bi-house-add-fill"></i> Announcements</a>


        <!-- Dropdown Menu - More -->
        <div class="dropdown-container">
            <button class="dropdown-toggle" type="button">
                <span>
                    <i class="bi bi-gear-fill"></i> More
                </span>
            </button>
            <div class="dropdown-menu-custom">
                <a href="admin_dashboard.php"><i class="bi bi-person-circle"></i> Student</a>
                <a href="ad_c_dashboard.php"><i class="bi bi-person-circle"></i> Coordinator</a>
                <a href="ad_co_dashboard.php"><i class="bi bi-person-circle"></i> Co-Coordinator</a>
            </div>
        </div>

        <a href="ad_logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>

        <div class="d-lg-none mt-4 text-center">
            <!-- Added id="closeMenuBtn" -->
            <button class="btn btn-sm btn-outline-danger" id="closeMenuBtn">Close Menu</button>
        </div>
    </div>

    <!-- Your existing table and button CSS (keeping it exactly as you had it) -->
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-dark: #7a0c15;
            --bg-main: #f3f5f9;
            --glass: rgba(255, 255, 255, 0.75);
        }

        body {
            background: linear-gradient(120deg, #fdfbfb, #ebedee);
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 270px;
            padding: 30px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0 !important;
            }
        }

        /* ===== TOP BAR ===== */
        .top-bar {
            background: var(--glass);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 20px 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar h1 {
            color: var(--galore-dark);
            font-weight: 800;
            font-size: 1.8rem;
            margin: 0;
        }

        /* ===== ADD USER BUTTON ===== */
        .btn-add-user {
            background: linear-gradient(135deg, var(--galore-red) 0%, #ff6b6b 100%);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-add-user:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(220, 53, 69, 0.3);
        }

        /* ===== DATA TABLE ===== */
        .data-table-container {
            background: var(--glass);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            position: relative;
        }

        .data-table-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--galore-red);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-header h2 {
            color: var(--galore-dark);
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 18px 12px 45px;
            border: 1.5px solid #f0f0f0;
            border-radius: 14px;
            background-color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            background-color: #fff;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
            outline: none;
        }

        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--galore-red);
        }

        /* Table styling */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead {
            background: linear-gradient(to right, rgba(220, 53, 69, 0.1), rgba(255, 107, 107, 0.05));
        }

        .data-table th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 700;
            color: var(--galore-dark);
            border-bottom: 2px solid rgba(220, 53, 69, 0.2);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            color: #444;
            vertical-align: middle;
        }

        .data-table tbody tr {
            transition: all 0.3s ease;
        }

        .data-table tbody tr:hover {
            background-color: rgba(220, 53, 69, 0.05);
            transform: translateX(5px);
        }

        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .status-active {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .status-pending {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .status-inactive {
            background-color: rgba(108, 117, 125, 0.15);
            color: #6c757d;
        }

        /* Action buttons */
        .action-btn {
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }

        .btn-edit:hover {
            background-color: rgba(0, 123, 255, 0.2);
        }

        .btn-delete {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--galore-red);
        }

        .btn-delete:hover {
            background-color: rgba(220, 53, 69, 0.2);
        }

        /* ===== ADD USER FORM MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1100;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            background: #ffffff;
            width: 100%;
            max-width: 600px;
            padding: 45px;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            animation: modalFadeIn 0.4s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-content::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: var(--galore-red);
        }

        .modal-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .modal-header h3 {
            color: var(--galore-red);
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .modal-header p {
            color: #888;
            font-size: 0.9rem;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 25px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: var(--galore-red);
        }

        .form-label {
            font-weight: 700;
            color: #444;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .form-control,
        .form-select {
            border: 1.5px solid #f0f0f0;
            border-radius: 14px;
            padding: 12px 18px;
            background-color: #fafafa;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #fff;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
            outline: none;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--galore-red) 0%, #ff6b6b 100%);
            color: white;
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.2);
            margin-top: 15px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(220, 53, 69, 0.3);
        }

        /* ===== PAGINATION ===== */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination {
            display: flex;
            gap: 8px;
        }

        .page-item {
            list-style: none;
        }

        .page-link {
            padding: 10px 16px;
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.08);
            color: var(--galore-dark);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: var(--galore-red);
        }

        .page-item.active .page-link {
            background: linear-gradient(to right, var(--galore-red), #ff6b6b);
            color: white;
            border-color: var(--galore-red);
        }

        /* ===== RESPONSIVE TABLE ===== */
        @media (max-width: 768px) {
            .data-table-container {
                overflow-x: auto;
            }

            .data-table {
                min-width: 700px;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-box {
                width: 100%;
            }

            .main-content {
                padding: 20px 15px;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                padding: 15px 20px;
            }

            .btn-add-user {
                align-self: flex-start;
            }
        }
    </style>

    <!-- JavaScript with Active Menu Highlighting -->
    <script>
        // Sidebar toggle function (mobile)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Function to set active menu item based on current page
        function setActiveMenuItem() {
            // Get current page filename (e.g., "ad_c_dashboard.php")
            const currentPage = window.location.pathname.split('/').pop();

            // Get all sidebar links (both direct links and dropdown menu links)
            const allLinks = document.querySelectorAll('.sidebar a, .dropdown-menu-custom a');

            // Remove active class from all links
            allLinks.forEach(link => {
                link.classList.remove('active');
            });

            // Remove active class from all dropdown containers
            document.querySelectorAll('.dropdown-container').forEach(container => {
                container.classList.remove('active');
            });

            // Find and highlight the matching link
            let activeLink = null;
            allLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage) {
                    activeLink = link;
                }
            });

            // If exact match found, highlight it
            if (activeLink) {
                activeLink.classList.add('active');

                // If the active link is inside a dropdown, open its parent dropdown
                const parentDropdown = activeLink.closest('.dropdown-container');
                if (parentDropdown) {
                    parentDropdown.classList.add('active');
                }
            } else {
                // If no exact match, try to find partial matches
                allLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href && href !== '#' && currentPage.includes(href.replace('.php', ''))) {
                        link.classList.add('active');
                        const parentDropdown = link.closest('.dropdown-container');
                        if (parentDropdown) {
                            parentDropdown.classList.add('active');
                        }
                    }
                });
            }

            // Handle pages with query parameters
            if (currentPage.includes('?')) {
                const basePage = currentPage.split('?')[0];
                allLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href === basePage) {
                        link.classList.add('active');
                        const parentDropdown = link.closest('.dropdown-container');
                        if (parentDropdown) {
                            parentDropdown.classList.add('active');
                        }
                    }
                });
            }
        }

        // Wait for DOM to be fully loaded
        document.addEventListener("DOMContentLoaded", function() {

            // Set active menu item
            setActiveMenuItem();

            // Get the menu button and close button
            const menuBtn = document.getElementById('menuToggleBtn');
            const closeMenuBtn = document.getElementById('closeMenuBtn');

            // Add click event to menu button
            if (menuBtn) {
                menuBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Add click event to close button
            if (closeMenuBtn) {
                closeMenuBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Dropdown functionality
            const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener("click", function(e) {
                    e.stopPropagation();

                    const container = this.closest(".dropdown-container");

                    // Close other dropdowns
                    document.querySelectorAll(".dropdown-container").forEach(item => {
                        if (item !== container) {
                            item.classList.remove("active");
                        }
                    });

                    // Toggle current dropdown
                    container.classList.toggle("active");
                });
            });

            // Close dropdown when clicking outside (but keep open if contains active link)
            document.addEventListener("click", function(e) {
                if (!e.target.closest('.dropdown-toggle') && !e.target.closest('.dropdown-menu-custom')) {
                    document.querySelectorAll(".dropdown-container").forEach(item => {
                        const hasActiveLink = item.querySelector('a.active');
                        if (!hasActiveLink) {
                            item.classList.remove("active");
                        }
                    });
                }
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                const sidebar = document.getElementById('sidebar');
                const menuBtn = document.getElementById('menuToggleBtn');

                if (window.innerWidth <= 991.98) {
                    if (sidebar && menuBtn && !sidebar.contains(e.target) && !menuBtn.contains(e.target) && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                const sidebar = document.getElementById('sidebar');
                if (window.innerWidth > 991.98 && sidebar) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>

</body>

</html>