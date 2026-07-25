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

// Create c_announce table
$announce_table = "CREATE TABLE IF NOT EXISTS c_announce (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    hero_title VARCHAR(255) NOT NULL,
    hero_subtitle VARCHAR(255) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $announce_table)) {
    // echo "Table 'c_announce' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle form submission for announcement page
if (isset($_POST['submit'])) {

    // Get form data
    $hero_title = mysqli_real_escape_string($con, $_POST['hero_title']);
    $hero_subtitle = mysqli_real_escape_string($con, $_POST['hero_subtitle']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing announcement
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE c_announce SET 
                        hero_title = '$hero_title',
                        hero_subtitle = '$hero_subtitle'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating announcement: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new announcement
        $insert_query = "INSERT INTO c_announce (hero_title, hero_subtitle) 
                         VALUES ('$hero_title', '$hero_subtitle')";

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

    $delete_query = "DELETE FROM c_announce WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting announcement: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all announcements from database for display
$announceData = [];
$select_query = "SELECT * FROM c_announce ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $announceData[] = $row;
    }
}
?>