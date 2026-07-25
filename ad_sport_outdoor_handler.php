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

// Create outdoor_header table
$outdoor_header_table = "CREATE TABLE IF NOT EXISTS outdoor_header (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    hero_title VARCHAR(255) NOT NULL,
    hero_subtitle VARCHAR(255) NOT NULL,
    section_title VARCHAR(255) NOT NULL,
    section_subtitle VARCHAR(255) NOT NULL,
    note_text TEXT NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $outdoor_header_table)) {
    // echo "Table 'outdoor_header' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Create outdoor_event table
$outdoor_event_table = "CREATE TABLE IF NOT EXISTS outdoor_event (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    -- icon VARCHAR(100) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $outdoor_event_table)) {
    // echo "Table 'outdoor_event' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle status toggle request for outdoor events
if (isset($_GET['toggle_event_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_event_id']);
    
    $toggle_query = "UPDATE outdoor_event SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// Handle form submission for outdoor header
if (isset($_POST['submit_header'])) {

    // Get form data
    $hero_title = mysqli_real_escape_string($con, $_POST['hero_title']);
    $hero_subtitle = mysqli_real_escape_string($con, $_POST['hero_subtitle']);
    $section_title = mysqli_real_escape_string($con, $_POST['section_title']);
    $section_subtitle = mysqli_real_escape_string($con, $_POST['section_subtitle']);
    $note_text = mysqli_real_escape_string($con, $_POST['note_text']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing header
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE outdoor_header SET 
                        hero_title = '$hero_title',
                        hero_subtitle = '$hero_subtitle',
                        section_title = '$section_title',
                        section_subtitle = '$section_subtitle',
                        note_text = '$note_text'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating header: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new header
        $insert_query = "INSERT INTO outdoor_header (hero_title, hero_subtitle, section_title, section_subtitle, note_text) 
                         VALUES ('$hero_title', '$hero_subtitle', '$section_title', '$section_subtitle', '$note_text')";

        if (mysqli_query($con, $insert_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Handle form submission for outdoor event - REMOVED STATUS FROM FORM
if (isset($_POST['submit_event'])) {

    // Get form data
    $event_name = mysqli_real_escape_string($con, $_POST['event_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    // $icon = mysqli_real_escape_string($con, $_POST['icon']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing event
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE outdoor_event SET 
                        event_name = '$event_name',
                        description = '$description'
                        -- icon = '$icon'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating event: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new event with default status 'Inactive'
        $insert_query = "INSERT INTO outdoor_event (event_name, description, status) 
                         VALUES ('$event_name', '$description',  'Inactive')";

        if (mysqli_query($con, $insert_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Handle delete request for outdoor header
if (isset($_GET['delete_header_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_header_id']);

    $delete_query = "DELETE FROM outdoor_header WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting header: " . mysqli_error($con) . "');</script>";
    }
}

// Handle delete request for outdoor event
if (isset($_GET['delete_event_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_event_id']);

    $delete_query = "DELETE FROM outdoor_event WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting event: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all headers from database for display
$sportData = [];
$select_query = "SELECT * FROM outdoor_header ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sportData[] = $row;
    }
}

// Fetch all events from database for display
$eventData = [];
$select_query = "SELECT * FROM outdoor_event ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $eventData[] = $row;
    }
}
?>