<?php
// navbar.php - Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Database connection
$host = 'localhost';
$dbname = 'galore2026';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
}

// Handle search query
$searchResults = [];
$searchTerm = '';

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $searchTerm = trim($_GET['search']);
    $searchPattern = "%{$searchTerm}%";
    
    try {
        // Search in outdoor events
        $stmt = $pdo->prepare("
            SELECT 
                'outdoor' as source,
                event_name as title,
                description as content,
                CONCAT('sports-outdoor.php?event=', id) as link
            FROM outdoor_event 
            WHERE event_name LIKE :search OR description LIKE :search
            AND status = 'Active'
        ");
        $stmt->execute(['search' => $searchPattern]);
        $outdoorResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Search in indoor events
        $stmt = $pdo->prepare("
            SELECT 
                'indoor' as source,
                event_name as title,
                description as content,
                CONCAT('sports-indoor.php?event=', id) as link
            FROM indoor_event 
            WHERE event_name LIKE :search OR description LIKE :search
            AND status = 'Active'
        ");
        $stmt->execute(['search' => $searchPattern]);
        $indoorResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Search in cultural events
        $stmt = $pdo->prepare("
            SELECT 
                'cultural' as source,
                event_name as title,
                description as content,
                CONCAT('cultural.php?event=', id) as link
            FROM cultural_event 
            WHERE event_name LIKE :search OR description LIKE :search
            AND status = 'Active'
        ");
        $stmt->execute(['search' => $searchPattern]);
        $culturalResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Search in event results (by event name, winner name, or team)
        $stmt = $pdo->prepare("
            SELECT 
                'result' as source,
                event_name as title,
                CONCAT('Winner: ', winner_name, ' (', team, ') - Score: ', score) as content,
                CONCAT('results.php?result=', id) as link,
                medal_type as extra_info
            FROM event_results 
            WHERE (event_name LIKE :search 
                OR winner_name LIKE :search 
                OR team LIKE :search)
            AND status = 'Active'
        ");
        $stmt->execute(['search' => $searchPattern]);
        $resultResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Combine all results
        $searchResults = array_merge($outdoorResults, $indoorResults, $culturalResults, $resultResults);
        
        // Optional: Sort results by relevance (you can customize this)
        usort($searchResults, function($a, $b) use ($searchTerm) {
            $a_relevance = 0;
            $b_relevance = 0;
            
            // Higher relevance if title matches exactly or starts with search term
            if (stripos($a['title'], $searchTerm) === 0) $a_relevance += 10;
            if (stripos($b['title'], $searchTerm) === 0) $b_relevance += 10;
            if (stripos($a['title'], $searchTerm) !== false) $a_relevance += 5;
            if (stripos($b['title'], $searchTerm) !== false) $b_relevance += 5;
            
            return $b_relevance - $a_relevance;
        });
        
    } catch(PDOException $e) {
        error_log("Search query failed: " . $e->getMessage());
        $searchResults = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Galore Header Layout</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- jQuery (optional, not required by Bootstrap 5 but kept safe) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- SweetAlert2 for enhanced alerts -->
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

    /* ===== BUTTON ===== */
    .download-btn {
      display: inline-block;
      padding: 12px 32px;
      background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
      color: #fff;
      text-decoration: none;
      border: 3px #dc3545;
      border-radius: 30px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .download-btn:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 25px rgba(220, 53, 69, 0.45);
    }

    /* Responsive Button */
    @media (max-width: 768px) {
      .download-btn {
        padding: 10px 25px;
        font-size: 14px;
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

    /* Responsive Header Logos */
    @media (max-width: 768px) {
      .header-logo {
        max-height: 50px;
      }
    }

    @media (max-width: 480px) {
      .header-logo {
        max-height: 40px;
      }
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

    /* Responsive Menu Links */
    @media (max-width: 991px) {
      .main-menu .nav-item {
        margin: 5px 0;
      }

      .main-menu .nav-link {
        font-size: 16px;
        padding: 8px 0;
      }
    }

    /* ===== DROPDOWN ===== */
    .dropdown-menu {
      border-radius: 12px;
      border: none;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
      margin-top: 8px;
      animation: dropdownFade 0.3s ease;
    }

    .dropdown-item {
      padding: 10px 18px;
      font-weight: 500;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dropdown-item:hover,
    .dropdown-item:focus,
    .dropdown-item:active {
      background-color: #dc3545 !important;
      color: #fff !important;
    }

    /* When Bootstrap adds active class */
    .dropdown-item.active,
    .dropdown-item.active:hover,
    .dropdown-item.active:focus {
      background-color: #dc3545 !important;
      color: #fff !important;
    }

    /* Responsive Dropdown */
    @media (max-width: 991px) {
      .dropdown-menu {
        position: static !important;
        transform: none !important;
        box-shadow: none;
        border: 1px solid #eee;
        margin: 5px 0;
        padding: 0;
      }

      .dropdown-item {
        padding: 8px 20px;
      }
    }

    /* Remove default arrow */
    .dropdown-toggle::after {
      display: none !important;
    }

    .navbar .nav-link .bi {
      color: red;
      margin-left: 4px;
      font-size: 0.8em;
    }

    /* ===== HOVER DROPDOWN (DESKTOP ONLY) ===== */
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

    /* ===== PROFILE DROPDOWN STYLES ===== */
 .profile-dropdown {
  position: relative;
  display: inline-block;
}

    .profile-icon {
      font-size: 32px;
      color: #dc3545;
      transition: 0.3s ease;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .profile-icon:hover {
      color: darkred;
      transform: scale(1.05);
    }

    .profile-icon .bi-chevron-down {
      font-size: 16px;
      transition: transform 0.3s ease;
    }

    .profile-dropdown:hover .profile-icon .bi-chevron-down {
      transform: rotate(180deg);
    }

.profile-dropdown-menu {
  position: absolute;
  top: 100%;
  right: 0;
  background: #fff;
  min-width: 280px;
  border-radius: 12px;
  border: none;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  margin-top: 12px;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 1000;
}

.profile-dropdown:hover .profile-dropdown-menu {
  opacity: 1;
  visibility: visible;
  margin-top: 8px;
}

.profile-dropdown-menu::before {
  content: '';
  position: absolute;
  top: -8px;
  right: 15px;
  width: 0;
  height: 0;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  border-bottom: 8px solid #fff;
}

.profile-header {
  padding: 15px 20px;
  border-bottom: 1px solid #eee;
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.profile-header .profile-name {
  font-weight: 700;
  color: #333;
  font-size: 15px;
  line-height: 1.4;
  display: block;
  width: 100%;
}

.profile-header .profile-email {
  font-size: 12px;
  color: #666;
  word-break: break-all;
  line-height: 1.4;
  display: block;
  width: 100%;
}

    .profile-menu-items {
      padding: 8px 0;
    }

    .profile-menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 20px;
      color: #333;
      text-decoration: none;
      transition: all 0.3s ease;
      font-size: 14px;
      font-weight: 500;
    }

    .profile-menu-item i {
      width: 20px;
      font-size: 16px;
      color: #dc3545;
    }

    .profile-menu-item:hover {
      background-color: #f8f9fa;
      color: #dc3545;
      padding-left: 25px;
    }

    .profile-menu-item:hover i {
      color: #dc3545;
    }

    .profile-divider {
      height: 1px;
      background-color: #eee;
      margin: 5px 0;
    }

    .logout-item {
      color: #dc3545;
    }

    .logout-item i {
      color: #dc3545;
    }

    .logout-item:hover {
      background-color: #dc3545;
      color: #fff;
    }

    .logout-item:hover i {
      color: #fff;
    }

    /* Responsive Profile Dropdown */
    @media (max-width: 991px) {
      .profile-dropdown {
        width: 100%;
      }

      .profile-dropdown-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        box-shadow: none;
        margin-top: 10px;
        width: 100%;
      display: inline-block;
      }

      .profile-dropdown.active .profile-dropdown-menu {
        display: block;
      }

      .profile-dropdown-menu::before {
        display: none;
      }

      .profile-icon .bi-chevron-down {
        display: inline-block;
      }
    }

    /* Responsive Profile Icon */
    @media (max-width: 768px) {
      .profile-icon {
        font-size: 28px;
      }

      .profile-icon .bi-chevron-down {
        font-size: 14px;
      }
    }

    /* ===== SEARCH ===== */
    .search-form {
      position: relative;
    }
    
    .search-form input {
      width: 250px;
      border-radius: 20px;
      border: 1px solid #ccc;
      padding: 6px 12px;
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
      padding: 6px 18px;
    }

    /* Search Results Modal/Section */
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
      max-width: 800px;
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

    .result-medal {
      display: inline-block;
      margin-left: 10px;
      font-size: 0.8rem;
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

    /* Responsive Search */
    @media (max-width: 991px) {
      .search-form {
        width: 100%;
        margin-top: 10px;
      }

      .search-form input {
        width: 100%;
      }

      .search-form input:focus {
        width: 100%;
      }

      .search-form button {
        width: 100%;
        margin-top: 5px;
      }
      
      .search-results-modal {
        margin: 10px;
        max-height: 90vh;
      }
    }

    /* ===== RIGHT SIDE ===== */
    .navbar-actions {
      margin-left: auto;
      gap: 15px;
      align-items: center;
    }

    /* Responsive Navbar Actions */
    @media (max-width: 991px) {
      .navbar-actions {
        flex-direction: column;
        margin-top: 15px;
        width: 100%;
      }
    }

    /* ===== RESPONSIVE FIXES ===== */
    @media (max-width: 991px) {
      .hero {
        margin-top: 42%;
        padding: 100px 10px 60px;
      }
    }

    @media (max-width: 768px) {
      .hero {
        margin-top: 45%;
        padding: 80px 10px 50px;
      }
    }

    @media (max-width: 480px) {
      .hero {
        margin-top: 55%;
        padding: 60px 10px 40px;
      }
    }

    /* Custom SweetAlert2 Styles - Fully Responsive */
    .custom-swal-popup {
      border-radius: 20px !important;
      border-top: 6px solid #dc3545 !important;
      width: auto !important;
      max-width: 90vw !important;
      margin: 0 auto !important;
    }

    .custom-swal-title {
      color: #dc3545 !important;
      font-weight: 700 !important;
      font-size: clamp(1.2rem, 4vw, 1.8rem) !important;
    }

    .custom-swal-confirm-btn {
      background: linear-gradient(135deg, #ff4d5a, #dc3545) !important;
      border: none !important;
      border-radius: 30px !important;
      padding: 10px 30px !important;
      font-weight: 600 !important;
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3) !important;
      font-size: clamp(0.85rem, 3vw, 1rem) !important;
      margin: 5px !important;
    }

    .custom-swal-confirm-btn:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4) !important;
    }

    .custom-swal-cancel-btn {
      background: #6c757d !important;
      border: none !important;
      border-radius: 30px !important;
      padding: 10px 30px !important;
      font-weight: 600 !important;
      font-size: clamp(0.85rem, 3vw, 1rem) !important;
      margin: 5px !important;
    }

    .custom-swal-cancel-btn:hover {
      background: #5a6268 !important;
      transform: translateY(-2px) !important;
    }

    /* Responsive button container */
    .swal2-actions {
      flex-wrap: wrap !important;
      gap: 5px !important;
    }

    /* Responsive icon */
    .swal2-icon {
      transform: scale(clamp(0.8, 2vw, 1)) !important;
      margin: 10px auto !important;
    }

    /* Responsive text */
    .swal2-html-container {
      font-size: clamp(0.9rem, 3vw, 1.1rem) !important;
      padding: 10px !important;
      word-break: break-word !important;
    }

    /* Responsive timer progress bar */
    .swal2-timer-progress-bar {
      height: 3px !important;
    }

    /* Mobile-specific adjustments */
    @media (max-width: 480px) {
      .custom-swal-popup {
        border-radius: 15px !important;
        padding: 15px !important;
      }

      .custom-swal-confirm-btn,
      .custom-swal-cancel-btn {
        width: 100% !important;
        margin: 5px 0 !important;
      }

      .swal2-actions {
        flex-direction: column !important;
        width: 100% !important;
      }
    }
  </style>
</head>

<body>

  <!-- ===== HEADER LOGOS ===== -->
  <div class="fixed-top">
    <div class="container-fluid header-box">
      <div class="row text-center align-items-center gx-1">
        <div class="col-6 col-md-3">
          <img src="Website/galore_half1.jpg" class="img-fluid header-logo" alt="Logo">
        </div>
        <div class="col-6 col-md-3">
          <img src="Website/rku_logo.png" class="img-fluid header-logo" alt="RKU Logo">
        </div>
        <div class="col-6 col-md-3">
          <img src="Website/galore_logo.png" class="img-fluid header-logo" alt="Galore Logo">
        </div>
        <div class="col-6 col-md-3">
          <img src="Website/galore_half2.png" class="img-fluid header-logo" alt="Galore Logo">
        </div>
      </div>
    </div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm ">
      <div class="container-fluid">

        <button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mynavbar">

          <!-- CENTER MENU -->
          <ul class="navbar-nav align-items-center main-menu mx-auto">

            <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                Events <i class="bi bi-caret-down-fill"></i>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="sports-outdoor.php">Sports-Outdoor</a></li>
                <li><a class="dropdown-item" href="sports-indoor.php">Sports-Indoor</a></li>
                <li><a class="dropdown-item" href="cultural.php">Cultural</a></li>
              </ul>
            </li>

            <li class="nav-item"><a class="nav-link" href="schedual.php">Schedule</a></li>
            <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
            <li class="nav-item"><a class="nav-link" href="results.php">Results</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="rules.php">Rules</a></li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                Registration <i class="bi bi-caret-down-fill"></i>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="registration.php">Register</a></li>
                <li><a class="dropdown-item" href="event_registration.php">Event Registration</a></li>
              </ul>
            </li>

          </ul>

          <!-- RIGHT SIDE - Profile Dropdown -->
          <!-- RIGHT SIDE - Profile Dropdown -->
          <div class="d-flex align-items-center navbar-actions">
            <div class="profile-dropdown" id="profileDropdown">
              <div class="profile-icon">
                <i class="bi bi-person-circle"></i>
                <i class="bi bi-chevron-down"></i>
              </div>
              <div class="profile-dropdown-menu">
                <div class="profile-header">
                  <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <div class="profile-name">
                      <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                    </div>
                    <div class="profile-email">
                      <?php echo htmlspecialchars($_SESSION['email']); ?>
                    </div>
                  <?php else: ?>
                    <div class="profile-name">
                      Guest User
                    </div>
                    <div class="profile-email">
                      Please login to access features
                    </div>
                  <?php endif; ?>
                </div>
                <div class="profile-menu-items">
                  <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <a href="profile.php" class="profile-menu-item">
                      <i class="bi bi-person"></i>
                      <span>My Profile</span>
                    </a>
                    <a href="change_password.php" class="profile-menu-item">
                      <i class="bi bi-key"></i>
                      <span>Change Password</span>
                    </a>
                    <div class="profile-divider"></div>
                    <a href="#" onclick="confirmLogout(event);" class="profile-menu-item logout-item">
                      <i class="bi bi-box-arrow-right"></i>
                      <span>Logout</span>
                    </a>
                  <?php else: ?>
                    <a href="login.php" class="profile-menu-item">
                      <i class="bi bi-box-arrow-in-right"></i>
                      <span>Login</span>
                    </a>
                    <a href="registration.php" class="profile-menu-item">
                      <i class="bi bi-person-plus"></i>
                      <span>Register</span>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <form class="d-flex search-form" id="searchForm" method="GET" action="">
              <input class="form-control me-2" type="search" name="search" placeholder="Search events, results..." value="<?php echo htmlspecialchars($searchTerm); ?>">
              <button class="btn btn-danger" type="submit">Search</button>
            </form>
          </div>

        </div>
      </div>
    </nav>
  </div>

  <!-- Search Results Modal -->
  <div class="search-results-container" id="searchResultsContainer">
    <div class="search-results-modal">
      <div class="search-results-header">
        <h3>Search Results: "<?php echo htmlspecialchars($searchTerm); ?>"</h3>
        <button class="close-results" onclick="closeSearchResults()">&times;</button>
      </div>
      <div class="search-results-body">
        <?php if (!empty($searchResults)): ?>
          <?php foreach($searchResults as $result): ?>
            <div class="result-item" onclick="window.location.href='<?php echo $result['link']; ?>'">
              <div class="result-title">
                <?php echo htmlspecialchars($result['title']); ?>
                <?php if (isset($result['extra_info']) && $result['extra_info'] == 'Gold'): ?>
                  <span class="result-medal">🥇</span>
                <?php elseif (isset($result['extra_info']) && $result['extra_info'] == 'Silver'): ?>
                  <span class="result-medal">🥈</span>
                <?php elseif (isset($result['extra_info']) && $result['extra_info'] == 'Bronze'): ?>
                  <span class="result-medal">🥉</span>
                <?php endif; ?>
              </div>
              <div class="result-content">
                <?php echo htmlspecialchars(substr($result['content'], 0, 150)) . (strlen($result['content']) > 150 ? '...' : ''); ?>
              </div>
              <div class="result-source">
                <?php 
                $sourceLabel = '';
                switch($result['source']) {
                  case 'outdoor':
                    $sourceLabel = '🏃 Outdoor Event';
                    break;
                  case 'indoor':
                    $sourceLabel = '🎯 Indoor Event';
                    break;
                  case 'cultural':
                    $sourceLabel = '🎭 Cultural Event';
                    break;
                  case 'result':
                    $sourceLabel = '🏆 Event Result';
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
            <p>Try searching with different keywords or browse our events below.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Enhanced Responsive Logout Confirmation Script -->
  <script>
    // Show search results if there's a search term
    <?php if (!empty($searchTerm)): ?>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('searchResultsContainer').style.display = 'flex';
    });
    <?php endif; ?>
    
    function closeSearchResults() {
      document.getElementById('searchResultsContainer').style.display = 'none';
      // Remove search parameter from URL without reloading
      const url = new URL(window.location.href);
      url.searchParams.delete('search');
      window.history.replaceState({}, document.title, url.toString());
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
      const container = document.getElementById('searchResultsContainer');
      if (e.target === container) {
        closeSearchResults();
      }
    });
    
    // Mobile dropdown toggle
    document.addEventListener('DOMContentLoaded', function() {
      const profileDropdown = document.getElementById('profileDropdown');
      const profileIcon = document.querySelector('.profile-icon');

      if (window.innerWidth <= 991) {
        profileIcon.addEventListener('click', function(e) {
          e.stopPropagation();
          profileDropdown.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
          if (!profileDropdown.contains(e.target)) {
            profileDropdown.classList.remove('active');
          }
        });
      }
    });

    function confirmLogout(event) {
      event.preventDefault(); // Prevent default link behavior

      // Check if mobile device
      const isMobile = window.innerWidth <= 768;

      Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out of your account!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, logout',
        cancelButtonText: 'Cancel',
        background: '#fff',
        backdrop: `rgba(220,53,69,0.2)`,
        customClass: {
          popup: 'custom-swal-popup',
          title: 'custom-swal-title',
          confirmButton: 'custom-swal-confirm-btn',
          cancelButton: 'custom-swal-cancel-btn'
        },
        showClass: {
          popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
        // Responsive settings
        width: isMobile ? '90%' : 'auto',
        padding: isMobile ? '1rem' : '1.5rem',
        timer: isMobile ? 0 : undefined // Disable timer on mobile
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect immediately to logout page
          window.location.href = 'logout.php';
        }
      });
    }

    // Optional: Add logout success message if coming from logout page
    $(document).ready(function() {
      // Check if URL has logout parameter
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('logout') && urlParams.get('logout') === 'success') {
        const isMobile = window.innerWidth <= 768;

        Swal.fire({
          icon: 'success',
          title: 'Logged Out Successfully!',
          text: 'You have been logged out of your account.',
          timer: isMobile ? 0 : 3000, // No timer on mobile
          showConfirmButton: true,
          confirmButtonColor: '#dc3545',
          confirmButtonText: 'OK',
          customClass: {
            popup: 'custom-swal-popup',
            confirmButton: 'custom-swal-confirm-btn'
          },
          width: isMobile ? '90%' : 'auto',
          padding: isMobile ? '1rem' : '1.5rem'
        });

        // Remove the parameter from URL without reloading
        const url = new URL(window.location.href);
        url.searchParams.delete('logout');
        window.history.replaceState({}, document.title, url.toString());
      }
    });

    // Handle window resize to adjust alert settings dynamically
    let resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        // Handle mobile dropdown behavior on resize
        const profileDropdown = document.getElementById('profileDropdown');
        if (window.innerWidth > 991) {
          profileDropdown.classList.remove('active');
        }
        console.log('Window resized - alerts will adjust on next trigger');
      }, 250);
    });
  </script>

  <!-- Add Animate.css for animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

</body>

</html>