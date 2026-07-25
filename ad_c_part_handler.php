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

// Create co_part table (for Participation)
$part_table = "CREATE TABLE IF NOT EXISTS co_part (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    hero_title VARCHAR(255) NOT NULL,
    hero_subtitle VARCHAR(255) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $part_table)) {
    // echo "Table 'co_part' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle form submission for participation page
if (isset($_POST['submit'])) {

    // Get form data (status not included from form)
    $hero_title = mysqli_real_escape_string($con, $_POST['hero_title']);
    $hero_subtitle = mysqli_real_escape_string($con, $_POST['hero_subtitle']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing participation page - status not updated from form
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE co_part SET 
                        hero_title = '$hero_title',
                        hero_subtitle = '$hero_subtitle'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating participation page: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new participation page - status defaults to 'Active' from table definition
        $insert_query = "INSERT INTO co_part (hero_title, hero_subtitle) 
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

// Handle status toggle request
if (isset($_GET['toggle_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_id']);
    
    $toggle_query = "UPDATE co_part SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);

    $delete_query = "DELETE FROM co_part WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting participation page: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all participation pages from database for display
$partData = [];
$select_query = "SELECT * FROM co_part ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $partData[] = $row;
    }
}
?>