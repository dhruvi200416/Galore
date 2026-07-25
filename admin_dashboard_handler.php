<?php
require_once 'admin_auth_check.php';
// Database connection
$con = mysqli_connect("localhost", "root", "");

// Create database if not exists
$create_db = "CREATE DATABASE IF NOT EXISTS galore2026";
if (mysqli_query($con, $create_db)) {
    // echo "Database checked/created successfully<br>";
} else {
    echo "Database error: " . mysqli_error($con) . "<br>";
}
mysqli_select_db($con, "galore2026");

// ==================== FETCH DASHBOARD DATA ====================

// Get total registrations count
$reg_query = "SELECT COUNT(*) as total FROM registration";
$reg_result = mysqli_query($con, $reg_query);
$reg_count = mysqli_fetch_assoc($reg_result)['total'];

// Get total events count from all three event tables
$events_query = "SELECT 
    (SELECT COUNT(*) FROM outdoor_event) + 
    (SELECT COUNT(*) FROM indoor_event) + 
    (SELECT COUNT(*) FROM cultural_event) as total";
$events_result = mysqli_query($con, $events_query);
$events_count = mysqli_fetch_assoc($events_result)['total'];

// Get total participants count from event_register table
$participants_query = "SELECT COUNT(*) as total FROM event_register";
$participants_result = mysqli_query($con, $participants_query);
$participants_count = mysqli_fetch_assoc($participants_result)['total'];

// Get total winners count from event_results
$winners_query = "SELECT COUNT(*) as total FROM event_results";
$winners_result = mysqli_query($con, $winners_query);
$winners_count = mysqli_fetch_assoc($winners_result)['total'];

// Get recent registrations for the table - Fetch last 2 rows
$recent_query = "SELECT * FROM registration ORDER BY id DESC LIMIT 2";
$recent_result = mysqli_query($con, $recent_query);

// Check if we have results and get column names for debugging
$has_results = mysqli_num_rows($recent_result) > 0;
$columns = [];
if ($has_results) {
    $first_row = mysqli_fetch_assoc($recent_result);
    $columns = array_keys($first_row);
    // Reset the result pointer to fetch all rows again
    mysqli_data_seek($recent_result, 0);
}

// Close the database connection (optional - can be kept open for later use)
// mysqli_close($con);
?>