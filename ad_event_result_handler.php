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

// Create event_results table
$event_results_table = "CREATE TABLE IF NOT EXISTS event_results (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    winner_name VARCHAR(255) NOT NULL,
    score VARCHAR(100) NOT NULL,
    team VARCHAR(255) NOT NULL,
    medal_type VARCHAR(50) NOT NULL,
    icons VARCHAR(50) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $event_results_table)) {
    // echo "Table 'event_results' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle form submission for event results
if (isset($_POST['submit'])) {

    // Get form data
    $event_name = mysqli_real_escape_string($con, $_POST['event_name']);
    $winner_name = mysqli_real_escape_string($con, $_POST['winner_name']);
    $score = mysqli_real_escape_string($con, $_POST['score']);
    $team = mysqli_real_escape_string($con, $_POST['team']);
    $medal_type = mysqli_real_escape_string($con, $_POST['medal_type']);
    $icons = mysqli_real_escape_string($con, $_POST['icons']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing event result
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE event_results SET 
                        event_name = '$event_name',
                        winner_name = '$winner_name',
                        score = '$score',
                        team = '$team',
                        medal_type = '$medal_type',
                        icons = '$icons'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating event result: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new event result
        $insert_query = "INSERT INTO event_results (event_name, winner_name, score, team, medal_type, icons) 
                         VALUES ('$event_name', '$winner_name', '$score', '$team', '$medal_type', '$icons')";

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

    $delete_query = "DELETE FROM event_results WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting event result: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all event results from database for display
$eventResultData = [];
$select_query = "SELECT * FROM event_results ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $eventResultData[] = $row;
    }
}

// Handle status toggle request
if (isset($_GET['toggle_status'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_status']);
    
    $toggle_query = "UPDATE event_results SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>