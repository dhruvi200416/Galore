<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];
$user = [];
$registered_events = null;
$outdoor_events = [];
$indoor_events = [];
$cultural_events = [];

// Fetch user data from registration table
$user_query = "SELECT id, enrollment_no, full_name, email, phone, branch, semester, gender, school, role, status, profile_pic, registration_date 
               FROM registration 
               WHERE id = ? AND status = 'Active'";

$stmt = mysqli_prepare($con, $user_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user = mysqli_fetch_assoc($user_result);
} else {
    // User not found or not active
    session_destroy();
    header("Location: login.php");
    exit();
}
mysqli_stmt_close($stmt);

// Fetch registered events from event_register table
if (!empty($user['enrollment_no'])) {
    $events_query = "SELECT * FROM event_register WHERE enrollment_no = ?";
    $events_stmt = mysqli_prepare($con, $events_query);
    mysqli_stmt_bind_param($events_stmt, "s", $user['enrollment_no']);
    mysqli_stmt_execute($events_stmt);
    $events_result = mysqli_stmt_get_result($events_stmt);
    
    if ($events_result && mysqli_num_rows($events_result) > 0) {
        $registered_events = mysqli_fetch_assoc($events_result);
        
        // Parse outdoor events - handle NULL and empty values
        if (isset($registered_events['Sports_Outdoor']) && !empty($registered_events['Sports_Outdoor'])) {
            $outdoor_events = explode(', ', $registered_events['Sports_Outdoor']);
        }
        
        // Parse indoor events
        if (isset($registered_events['Sports_Indoor']) && !empty($registered_events['Sports_Indoor'])) {
            $indoor_events = explode(', ', $registered_events['Sports_Indoor']);
        }
        
        // Parse cultural events
        if (isset($registered_events['cultur']) && !empty($registered_events['cultur'])) {
            $cultural_events = explode(', ', $registered_events['cultur']);
        }
    }
    if (isset($events_stmt)) {
        mysqli_stmt_close($events_stmt);
    }
}

// Close connection at the end of file
// Don't close here if you need it in profile.php
?>