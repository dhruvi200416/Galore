<?php
// admin_auth_check.php - Session check for all admin pages
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Check if user has admin role (only Admin, Coordinator, co-coordinator allowed)
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Coordinator' && $_SESSION['role'] != 'co-coordinator')) {
    // Not authorized for admin area, redirect to participant profile
    header("Location: profile.php");
    exit();
}

// Optional: Check session timeout (30 minutes = 1800 seconds)
$timeout_duration = 1800; // 30 minutes

if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout_duration) {
    // Session expired
    session_destroy();
    header("Location: login.php?error=session_expired");
    exit();
}

// Update last activity time
$_SESSION['login_time'] = time();

// Optional: Verify user still exists in database and is active
// Uncomment this section if you want extra security
/*
$con = mysqli_connect("localhost", "root", "", "galore2026");
if ($con) {
    $user_id = mysqli_real_escape_string($con, $_SESSION['user_id']);
    $query = "SELECT * FROM ad_register WHERE id = '$user_id' AND status = 'Active' LIMIT 1";
    $result = mysqli_query($con, $query);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        // User not found or inactive
        session_destroy();
        header("Location: login.php?error=account_inactive");
        exit();
    }
    mysqli_close($con);
}
*/
?>