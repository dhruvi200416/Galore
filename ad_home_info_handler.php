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

// Create home_info table
$home_info_table = "CREATE TABLE IF NOT EXISTS home_info (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    heading VARCHAR(255) NOT NULL,
    sub_heading VARCHAR(255) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $home_info_table)) {
    // Table created successfully
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// ==================== HANDLE FORM SUBMISSION ====================
if (isset($_POST['submit'])) {

    // Get form data
    $heading = mysqli_real_escape_string($con, $_POST['heading']);
    $sub_heading = mysqli_real_escape_string($con, $_POST['sub_heading']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing info
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE home_info SET 
                        heading = '$heading',
                        sub_heading = '$sub_heading'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            header("Location: ad_home_info.php");
            exit();
        } else {
            echo "<script>alert('Error updating info: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new info
        $insert_query = "INSERT INTO home_info (heading, sub_heading) 
                         VALUES ('$heading', '$sub_heading')";

        if (mysqli_query($con, $insert_query)) {
            header("Location: ad_home_info.php");
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== HANDLE DELETE REQUEST ====================
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);

    $delete_query = "DELETE FROM home_info WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: ad_home_info.php");
        exit();
    } else {
        echo "<script>alert('Error deleting info: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== FETCH ALL HOMEPAGE INFO ====================
$homepageData = [];
$select_query = "SELECT * FROM home_info ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $homepageData[] = $row;
    }
}

// Close database connection
// mysqli_close($con);
?>