<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// ⏱️ 20 minutes = 1200 seconds
$timeout = 2000;

// ✅ Check session timeout
if (isset($_SESSION['time'])) {
    if (time() - $_SESSION['time'] > $timeout) {
        session_destroy();
        header("Location: login.php?timeout=1");
        exit();
    }
}
$_SESSION['time'] = time();

// ✅ Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// ✅ Check role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Co-coordinator') {
    header("Location: login.php");
    exit();
}

// ✅ Get user info from session for navbar display
$user_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'User';
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// ============================
// SEARCH FUNCTIONALITY
// ============================
$searchResults = [];
$searchTerm = '';
$showSearchModal = false;

if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    $showSearchModal = true;
    $searchTerm = mysqli_real_escape_string($con, trim($_GET['q']));
    $searchPattern = $searchTerm;
    
    // Search in event_register table (students)
    $studentsQuery = "SELECT 
        'student' as source,
        full_name as title,
        enrollment_no,
        email,
        branch,
        school,
        semester,
        phone,
        CONCAT('Enrollment: ', enrollment_no, ' | Branch: ', branch, ' | School: ', school) as content,
        id as record_id
    FROM event_register 
    WHERE status = 'active' AND (
        full_name LIKE '%$searchPattern%' OR 
        enrollment_no LIKE '%$searchPattern%' OR 
        email LIKE '%$searchPattern%' OR
        branch LIKE '%$searchPattern%' OR
        school LIKE '%$searchPattern%' OR
        Sports_Outdoor LIKE '%$searchPattern%' OR
        Sports_Indoor LIKE '%$searchPattern%' OR
        cultur LIKE '%$searchPattern%'
    )
    ORDER BY registration_date DESC
    LIMIT 30";
    
    $studentsResult = mysqli_query($con, $studentsQuery);
    if ($studentsResult) {
        while ($row = mysqli_fetch_assoc($studentsResult)) {
            $searchResults[] = $row;
        }
    }
    
    // Search in event_results table (winners)
    $winnersQuery = "SELECT 
        'winner' as source,
        event_name as title,
        winner_name,
        team,
        medal_type,
        score,
        CONCAT('Winner: ', winner_name, ' (', team, ') - Score: ', score) as content,
        id as record_id
    FROM event_results 
    WHERE status = 'Active' AND (
        event_name LIKE '%$searchPattern%' OR 
        winner_name LIKE '%$searchPattern%' OR 
        team LIKE '%$searchPattern%' OR
        medal_type LIKE '%$searchPattern%'
    )
    ORDER BY created_at DESC
    LIMIT 30";
    
    $winnersResult = mysqli_query($con, $winnersQuery);
    if ($winnersResult) {
        while ($row = mysqli_fetch_assoc($winnersResult)) {
            $searchResults[] = $row;
        }
    }
    
    // Search in outdoor events
    $outdoorQuery = "SELECT 
        'outdoor' as source,
        event_name as title,
        description as content,
        id as record_id
    FROM outdoor_event 
    WHERE (event_name LIKE '%$searchPattern%' OR description LIKE '%$searchPattern%')
    AND status = 'Active'
    LIMIT 10";
    
    $outdoorResult = mysqli_query($con, $outdoorQuery);
    if ($outdoorResult) {
        while ($row = mysqli_fetch_assoc($outdoorResult)) {
            $searchResults[] = $row;
        }
    }
    
    // Search in indoor events
    $indoorQuery = "SELECT 
        'indoor' as source,
        event_name as title,
        description as content,
        id as record_id
    FROM indoor_event 
    WHERE (event_name LIKE '%$searchPattern%' OR description LIKE '%$searchPattern%')
    AND status = 'Active'
    LIMIT 10";
    
    $indoorResult = mysqli_query($con, $indoorQuery);
    if ($indoorResult) {
        while ($row = mysqli_fetch_assoc($indoorResult)) {
            $searchResults[] = $row;
        }
    }
    
    // Search in cultural events
    $culturalQuery = "SELECT 
        'cultural' as source,
        event_name as title,
        description as content,
        id as record_id
    FROM cultural_event 
    WHERE (event_name LIKE '%$searchPattern%' OR description LIKE '%$searchPattern%')
    AND status = 'Active'
    LIMIT 10";
    
    $culturalResult = mysqli_query($con, $culturalQuery);
    if ($culturalResult) {
        while ($row = mysqli_fetch_assoc($culturalResult)) {
            $searchResults[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Galore - Co-coordinator Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    body {
      background-color: #f8f9fa;
      font-family: "Segoe UI", Arial, sans-serif;
    }

    /* ===== HERO (SAME AS RULES PAGE) ===== */
    .hero {
      margin-top: 10%;
      background: linear-gradient(135deg, #dc3545, #7a1c25);
      color: #fff;
      text-align: center;
      padding: 160px 20px 100px;
      position: relative;
      overflow: hidden;
    }

    .hero::after {
      content: "";
      position: absolute;
      bottom: -60px;
      left: 0;
      width: 100%;
      height: 120px;
      background: #fff;
      border-radius: 50% 50% 0 0;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 900;
      letter-spacing: 2px;
      margin-bottom: 12px;
    }

    .hero p {
      font-size: 1.2rem;
      opacity: 0.95;
    }

    /* Responsive Hero */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.2rem;
      }

      .hero p {
        font-size: 1rem;
      }
    }

    @media (max-width: 480px) {
      .hero h1 {
        font-size: 1.8rem;
      }

      .hero p {
        font-size: 0.9rem;
      }
    }
        /* ===== HEADER LOGOS ===== */
        .header-box {
            background: #ffffff;
            border-radius: 0 0 20px 20px;
            padding: 8px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .header-logo {
            max-height: 80px;
            width: auto;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: #ffffff;
            border-top: 3px solid #dc3545;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        /* ===== MENU LINKS ===== */
        .main-menu .nav-item {
            margin: 0 14px;
        }

        .main-menu .nav-link {
            font-size: 17px;
            font-weight: 600;
            color: #000;
            position: relative;
            transition: color 0.3s ease;
        }

        .main-menu .nav-link::after {
            content: "";
            position: absolute;
            width: 0%;
            height: 2px;
            background: #dc3545;
            left: 0;
            bottom: -5px;
            transition: width 0.3s ease;
        }

        .main-menu .nav-link:hover {
            color: #dc3545;
        }

        .main-menu .nav-link:hover::after {
            width: 100%;
        }

        /* ===== DROPDOWN MENU ===== */
        .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            margin-top: 8px;
            animation: dropdownFade 0.25s ease;
        }

        .dropdown-item {
            padding: 10px 18px;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: #dc3545 !important;
            color: #ffffff !important;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .navbar .nav-link .bi {
            color: red;
            margin-left: 4px;
            font-size: 0.8em;
        }

        @media (min-width: 992px) {
            .navbar .dropdown:hover>.dropdown-menu {
                display: block;
            }
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== PROFILE ICON ===== */
        .profile-icon {
            font-size: 28px;
            color: #dc3545;
            transition: 0.3s ease;
            text-decoration: none;
        }

        .profile-icon:hover {
            color: darkred;
            transform: scale(1.1);
        }

        /* ===== SEARCH ===== */
        .search-form {
            display: flex;
            gap: 5px;
        }
        
        .search-form input {
            width: 250px;
            border-radius: 20px;
            border: 1px solid #ccc;
            padding: 6px 15px;
            transition: all 0.3s ease;
        }

        .search-form input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 6px #dc3545;
            outline: none;
            width: 300px;
        }

        .search-form button {
            border-radius: 20px;
            padding: 6px 20px;
        }

        /* Search Results Modal */
        .search-results-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .search-results-modal {
            background: white;
            border-radius: 20px;
            max-width: 900px;
            width: 100%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .search-results-header {
            background: linear-gradient(135deg, #dc3545, #7a1c25);
            color: white;
            padding: 20px;
            border-radius: 20px 20px 0 0;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .search-results-header h3 {
            margin: 0;
            font-size: 1.5rem;
        }

        .close-results {
            position: absolute;
            right: 20px;
            top: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .close-results:hover {
            transform: scale(1.1);
        }

        .search-results-body {
            padding: 20px;
        }

        .result-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .result-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .result-title {
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .result-content {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .result-source {
            font-size: 0.8rem;
            color: #999;
            display: inline-block;
            padding: 2px 8px;
            background: #f0f0f0;
            border-radius: 12px;
        }

        .result-details {
            font-size: 0.8rem;
            color: #666;
            margin-top: 5px;
        }

        .result-medal {
            display: inline-block;
            margin-left: 10px;
            font-size: 0.9rem;
        }

        .badge-enrollment {
            background: #e3f2fd;
            color: #1976d2;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            display: inline-block;
            margin-right: 5px;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .no-results i {
            font-size: 48px;
            margin-bottom: 15px;
        }

        /* Search filter tabs */
        .search-filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .filter-tab {
            padding: 5px 15px;
            border-radius: 20px;
            background: #f0f0f0;
            color: #666;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .filter-tab:hover, .filter-tab.active {
            background: #dc3545;
            color: white;
        }

        /* ===== RIGHT SIDE ===== */
        .navbar-actions {
            margin-left: auto;
            gap: 15px;
            display: flex;
            align-items: center;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            body {
                padding-top: 160px;
            }
            
            .navbar-actions {
                flex-direction: column;
                margin-top: 15px;
                width: 100%;
            }

            .search-form {
                width: 100%;
            }
            
            .search-form input {
                width: 100%;
            }
            
            .search-form input:focus {
                width: 100%;
            }

            .main-menu {
                text-align: center;
            }
            
            .header-logo {
                max-height: 50px;
            }
        }
        
        @media (max-width: 768px) {
            body {
                padding-top: 140px;
            }
            
            .search-results-modal {
                margin: 10px;
                max-height: 90vh;
            }
            
            .search-results-header h3 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>

    <!-- ===== HEADER LOGOS ===== -->
    <div class="fixed-top">
        <div class="container-fluid header-box">
            <div class="row text-center align-items-center gx-1 gy-2">
                <div class="col-6 col-md-3">
                    <img src="Website/galore_half1.jpg" class="img-fluid header-logo" alt="Galore Logo 1">
                </div>
                <div class="col-6 col-md-3">
                    <img src="Website/rku_logo.png" class="img-fluid header-logo" alt="RKU Logo">
                </div>
                <div class="col-6 col-md-3">
                    <img src="Website/galore_logo.png" class="img-fluid header-logo" alt="Galore Logo">
                </div>
                <div class="col-6 col-md-3">
                    <img src="Website/galore_half2.png" class="img-fluid header-logo" alt="Galore Logo 2">
                </div>
            </div>
        </div>

        <!-- ===== NAVBAR ===== -->
        <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
            <div class="container-fluid">

                <button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mynavbar">

                    <!-- CENTER MENU -->
                    <ul class="navbar-nav align-items-center main-menu mx-auto">
                        <li class="nav-item"><a class="nav-link" href="co_dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="co_my_school.php">My School</a></li>
                        <li class="nav-item"><a class="nav-link" href="co_create_team.php">Create Team</a></li>
                        <li class="nav-item"><a class="nav-link" href="co_schedule.php">Schedule</a></li>
                        <li class="nav-item"><a class="nav-link" href="co_announcement.php">Announcements</a></li>
                    </ul>

                    <!-- RIGHT SIDE -->
                    <div class="navbar-actions">
                        <div class="dropdown">
                            <a href="#" class="profile-icon dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle" style="font-size: 24px;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-header text-muted">
                                    <small>Welcome, <?php echo htmlspecialchars($user_name); ?></small>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="co_profile.php">
                                        <i class="bi bi-person"></i> Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="confirmLogout(event)">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Simple Search Form - No Dropdown -->
                        <form class="d-flex search-form" method="GET" action="" id="searchForm">
                            <input class="form-control" type="search" name="q" placeholder="Search by name, enrollment, event..." value="<?php echo htmlspecialchars($searchTerm); ?>" aria-label="Search">
                            <button class="btn btn-danger" type="submit">
                                 Search
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </nav>
    </div>

    <!-- Search Results Modal -->
    <?php if ($showSearchModal): ?>
    <div class="search-results-container" id="searchResultsContainer" style="display: flex;">
        <div class="search-results-modal">
            <div class="search-results-header">
                <h3>
                    Search Results: "<?php echo htmlspecialchars($searchTerm); ?>"
                    <small style="font-size: 14px; opacity: 0.8;">(<?php echo count($searchResults); ?> results)</small>
                </h3>
                <button class="close-results" onclick="closeSearchResults()">&times;</button>
            </div>
            <div class="search-results-body">
                <?php if (!empty($searchResults)): ?>
                    <!-- Filter tabs inside modal -->
                    <div class="search-filter-tabs">
                        <span class="filter-tab active" onclick="filterModalResults('all')">All</span>
                        <span class="filter-tab" onclick="filterModalResults('student')">Students</span>
                        <span class="filter-tab" onclick="filterModalResults('winner')">Winners</span>
                        <span class="filter-tab" onclick="filterModalResults('outdoor')">Outdoor</span>
                        <span class="filter-tab" onclick="filterModalResults('indoor')">Indoor</span>
                        <span class="filter-tab" onclick="filterModalResults('cultural')">Cultural</span>
                    </div>
                    
                    <?php foreach($searchResults as $index => $result): ?>
                        <div class="result-item" data-source="<?php echo $result['source']; ?>" 
                             onclick="window.location.href='<?php 
                                if ($result['source'] == 'student') echo 'co_student_details.php?id=' . $result['record_id'];
                                elseif ($result['source'] == 'winner') echo 'co_winner_details.php?id=' . $result['record_id'];
                                elseif ($result['source'] == 'outdoor') echo 'c_engineering.php?event=' . $result['record_id'];
                                elseif ($result['source'] == 'indoor') echo 'c_engineering.php?event=' . $result['record_id'];
                                elseif ($result['source'] == 'cultural') echo 'c_engineering.php?event=' . $result['record_id'];
                                else echo '#';
                             ?>'">
                            <div class="result-title">
                                <?php echo htmlspecialchars($result['title']); ?>
                                <?php if (isset($result['medal_type'])): ?>
                                    <span class="result-medal">
                                        <?php 
                                        if ($result['medal_type'] == 'Gold') echo '🥇';
                                        elseif ($result['medal_type'] == 'Silver') echo '🥈';
                                        elseif ($result['medal_type'] == 'Bronze') echo '🥉';
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="result-content">
                                <?php echo htmlspecialchars(substr($result['content'], 0, 150)) . (strlen($result['content']) > 150 ? '...' : ''); ?>
                            </div>
                            <?php if ($result['source'] == 'student'): ?>
                                <div class="result-details">
                                    <span class="badge-enrollment">📚 Enrollment: <?php echo htmlspecialchars($result['enrollment_no']); ?></span>
                                    <span class="badge-enrollment">🏫 Branch: <?php echo htmlspecialchars($result['branch']); ?></span>
                                    <span class="badge-enrollment">📞 Phone: <?php echo htmlspecialchars($result['phone']); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="result-source">
                                <?php 
                                $sourceLabel = '';
                                switch($result['source']) {
                                    case 'student':
                                        $sourceLabel = '📚 Student Registration';
                                        break;
                                    case 'winner':
                                        $sourceLabel = '🏆 Winner';
                                        break;
                                    case 'outdoor':
                                        $sourceLabel = '🏃 Outdoor Event';
                                        break;
                                    case 'indoor':
                                        $sourceLabel = '🎯 Indoor Event';
                                        break;
                                    case 'cultural':
                                        $sourceLabel = '🎭 Cultural Event';
                                        break;
                                }
                                echo $sourceLabel;
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results">
                        <i class="bi bi-search"></i>
                        <h4>No results found</h4>
                        <p>We couldn't find any matches for "<?php echo htmlspecialchars($searchTerm); ?>"</p>
                        <p>Try searching with different keywords.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
    function closeSearchResults() {
        document.getElementById('searchResultsContainer').style.display = 'none';
        // Remove search parameter from URL without reloading
        const url = new URL(window.location.href);
        url.searchParams.delete('q');
        window.history.replaceState({}, document.title, url.toString());
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const container = document.getElementById('searchResultsContainer');
        if (container && e.target === container) {
            closeSearchResults();
        }
    });
    
    // Filter results in modal by source type
    function filterModalResults(type) {
        var items = document.querySelectorAll('.result-item');
        var visibleCount = 0;
        
        items.forEach(function(item) {
            if (type === 'all') {
                item.style.display = 'block';
                visibleCount++;
            } else {
                if (item.getAttribute('data-source') === type) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            }
        });
        
        // Update active tab
        var tabs = document.querySelectorAll('.filter-tab');
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
            if (tab.getAttribute('onclick').includes(type)) {
                tab.classList.add('active');
            }
        });
        
        // Show/hide no results message if needed
        var noResultsDiv = document.querySelector('.no-results');
        if (noResultsDiv) {
            if (visibleCount === 0 && type !== 'all') {
                noResultsDiv.style.display = 'block';
            } else {
                noResultsDiv.style.display = 'none';
            }
        }
    }

    function confirmLogout(event) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of your account!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'co_logout.php';
            }
        });
    }
    </script>
</body>
</html>