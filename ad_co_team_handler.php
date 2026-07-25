<?php
require_once 'admin_auth_check.php';

$con = mysqli_connect("localhost", "root", "");

// Create database if not exists (to avoid error if it already exists)
$create_db = "CREATE DATABASE IF NOT EXISTS galore2026";
if (mysqli_query($con, $create_db)) {
    //  echo "Database checked/created successfully<br>";
} else {
    echo "Database error: " . mysqli_error($con) . "<br>";
}

// Select the database
mysqli_select_db($con, "galore2026");

// Create teams table with all required fields
$teams_table = "CREATE TABLE IF NOT EXISTS teams (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    event_name VARCHAR(255) NOT NULL,
    event_type VARCHAR(100) NOT NULL,
    game_name VARCHAR(255) NOT NULL,
    school VARCHAR(255) NOT NULL,
    coordinator_email VARCHAR(255) NOT NULL,
    coordinator_role VARCHAR(100) NOT NULL,
    player_ids TEXT,
    player_count INT(11) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $teams_table)) {
    // echo "Table 'teams' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// ==================== HANDLE STATUS TOGGLE FOR TEAMS ====================
if (isset($_GET['toggle_team_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_team_id']);
    
    $toggle_query = "UPDATE teams SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// Handle form submission for teams
if (isset($_POST['submit'])) {

    // Get form data
    $team_name = mysqli_real_escape_string($con, $_POST['team_name']);
    $event_name = mysqli_real_escape_string($con, $_POST['event_name']);
    $event_type = mysqli_real_escape_string($con, $_POST['event_type']);
    $game_name = mysqli_real_escape_string($con, $_POST['game_name']);
    $school = mysqli_real_escape_string($con, $_POST['school']);
    $coordinator_email = mysqli_real_escape_string($con, $_POST['coordinator_email']);
    $coordinator_role = mysqli_real_escape_string($con, $_POST['coordinator_role']);
    $player_ids = mysqli_real_escape_string($con, $_POST['player_ids']);
    $player_count = (int)$_POST['player_count'];
    $status = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : 'Active';

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing team
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE teams SET 
                        team_name = '$team_name',
                        event_name = '$event_name',
                        event_type = '$event_type',
                        game_name = '$game_name',
                        school = '$school',
                        coordinator_email = '$coordinator_email',
                        coordinator_role = '$coordinator_role',
                        player_ids = '$player_ids',
                        player_count = '$player_count',
                        status = '$status'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating team: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new team
        $insert_query = "INSERT INTO teams (team_name, event_name, event_type, game_name, school, coordinator_email, coordinator_role, player_ids, player_count, status) 
                         VALUES ('$team_name', '$event_name', '$event_type', '$game_name', '$school', '$coordinator_email', '$coordinator_role', '$player_ids', '$player_count', '$status')";

        if (mysqli_query($con, $insert_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);

    $delete_query = "DELETE FROM teams WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting team: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all teams from database for display
$teamsData = [];
$select_query = "SELECT * FROM teams ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $teamsData[] = $row;
    }
}
?>