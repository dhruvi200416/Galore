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

// Create schedule_events table
$schedule_events_table = "CREATE TABLE IF NOT EXISTS schedule_events (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    day_title VARCHAR(255) NOT NULL,
    event_time VARCHAR(100) NOT NULL,
    event_name VARCHAR(255) NOT NULL,
    event_location VARCHAR(255) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $schedule_events_table)) {
    // echo "Table 'schedule_events' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle form submission for schedule events
if (isset($_POST['submit'])) {

    // Get form data
    $day_title = mysqli_real_escape_string($con, $_POST['day_title']);
    $event_time = mysqli_real_escape_string($con, $_POST['event_time']);
    $event_name = mysqli_real_escape_string($con, $_POST['event_name']);
    $event_location = mysqli_real_escape_string($con, $_POST['event_location']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing event
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE schedule_events SET 
                        day_title = '$day_title',
                        event_time = '$event_time',
                        event_name = '$event_name',
                        event_location = '$event_location'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating event: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new event
        $insert_query = "INSERT INTO schedule_events (day_title, event_time, event_name, event_location) 
                         VALUES ('$day_title', '$event_time', '$event_name', '$event_location')";

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

    $delete_query = "DELETE FROM schedule_events WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting event: " . mysqli_error($con) . "');</script>";
    }
}

// Handle status toggle request
if (isset($_GET['toggle_status'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_status']);
    
    // First get current status
    $status_query = "SELECT status FROM schedule_events WHERE id = '$toggle_id'";
    $status_result = mysqli_query($con, $status_query);
    
    if ($status_result && mysqli_num_rows($status_result) > 0) {
        $row = mysqli_fetch_assoc($status_result);
        $current_status = $row['status'];
        $new_status = ($current_status == 'Active') ? 'Inactive' : 'Active';
        
        $update_status_query = "UPDATE schedule_events SET status = '$new_status' WHERE id = '$toggle_id'";
        if (mysqli_query($con, $update_status_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Event not found');</script>";
    }
}

// Fetch all events from database for display
$eventsData = [];
$select_query = "SELECT * FROM schedule_events ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $eventsData[] = $row;
    }
}
?>