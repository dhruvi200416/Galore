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

// Create circulars table
$circulars_table = "CREATE TABLE IF NOT EXISTS circulars (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    circular_date VARCHAR(50) NOT NULL,
    display_name VARCHAR(255) NOT NULL,
    detailed_rules TEXT,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );";

if (mysqli_query($con, $circulars_table)) {
    // echo "Table 'circulars' created successfully";
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Handle form submission for circulars
if (isset($_POST['submit'])) {

    // Get form data
    $circular_date = mysqli_real_escape_string($con, $_POST['date']);
    $display_name = mysqli_real_escape_string($con, $_POST['display_name']);
    
    // Handle detailed rules (JSON format)
    $detailed_rules = "";
    if (isset($_POST['detailed_rules']) && !empty($_POST['detailed_rules'])) {
        $detailed_rules = mysqli_real_escape_string($con, $_POST['detailed_rules']);
    }

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing circular
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE circulars SET 
                        circular_date = '$circular_date',
                        display_name = '$display_name',
                        detailed_rules = '$detailed_rules'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            // Redirect to the same page to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Error updating circular: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new circular
        $insert_query = "INSERT INTO circulars (circular_date, display_name, detailed_rules) 
                         VALUES ('$circular_date', '$display_name', '$detailed_rules')";

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

    $delete_query = "DELETE FROM circulars WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting circular: " . mysqli_error($con) . "');</script>";
    }
}
// Handle status toggle request
if (isset($_GET['toggle_status'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_status']);
    
    $toggle_query = "UPDATE circulars SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch all circulars from database for display
$circularData = [];
$select_query = "SELECT * FROM circulars ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Parse detailed rules from JSON if needed
        if (!empty($row['detailed_rules'])) {
            $row['detailed_rules'] = json_decode($row['detailed_rules'], true);
        } else {
            $row['detailed_rules'] = [];
        }
        $circularData[] = $row;
    }
}
?>
