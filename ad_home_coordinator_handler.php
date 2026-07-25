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

// Create home_coordinators table
$coordinators_table = "CREATE TABLE IF NOT EXISTS home_coordinators (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Inactive',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $coordinators_table)) {
    // Table created successfully
} else {
    // echo "Table not created: " . mysqli_error($con);
}

// Create website directory if it doesn't exist
if (!file_exists('website')) {
    mkdir('website', 0777, true);
}

// ==================== HANDLE FORM SUBMISSION ====================
if (isset($_POST['submit'])) {

    // Get form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);

    // Handle file upload for image
    $image = "";
    $upload_new_image = false;
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Target directory is the website folder
        $target_dir = "website/";
        
        // Get original filename
        $original_filename = $_FILES["image"]["name"];
        // Remove any path information
        $original_filename = basename($original_filename);
        
        $target_file = $target_dir . $original_filename;
        
        // Check if file already exists, if yes, add a number suffix
        $file_counter = 1;
        $file_pathinfo = pathinfo($target_file);
        while (file_exists($target_file)) {
            $original_filename = $file_pathinfo['filename'] . '_' . $file_counter . '.' . $file_pathinfo['extension'];
            $target_file = $target_dir . $original_filename;
            $file_counter++;
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = "website/" . $original_filename;
            $upload_new_image = true;
        }
    }

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing coordinator
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE home_coordinators SET 
                        name = '$name',
                        role = '$role',
                        phone = '$phone'";
        
        // Add image to update if a new one was uploaded
        if ($upload_new_image && !empty($image)) {
            // Get old image to delete
            $old_image_query = "SELECT image FROM home_coordinators WHERE id = '$edit_id'";
            $old_result = mysqli_query($con, $old_image_query);
            if (mysqli_num_rows($old_result) > 0) {
                $old_row = mysqli_fetch_assoc($old_result);
                if (!empty($old_row['image']) && file_exists($old_row['image'])) {
                    unlink($old_row['image']);
                }
            }
            $update_query .= ", image = '$image'";
        }
        
        $update_query .= " WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            header("Location: ad_home_coordinator.php");
            exit();
        } else {
            echo "<script>alert('Error updating coordinator: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new coordinator - image is required for new coordinators
        if (empty($image)) {
            echo "<script>alert('Image is required for new coordinators.');</script>";
        } else {
            $status = 'Inactive'; // Default status for new coordinators
            $insert_query = "INSERT INTO home_coordinators (image, name, role, phone, status) 
                             VALUES ('$image', '$name', '$role', '$phone', '$status')";

            if (mysqli_query($con, $insert_query)) {
                header("Location: ad_home_coordinator.php");
                exit();
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        }
    }
}

// ==================== HANDLE STATUS TOGGLE ====================
if (isset($_GET['toggle_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_id']);
    
    $toggle_query = "UPDATE home_coordinators SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: ad_home_coordinator.php");
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== HANDLE DELETE REQUEST ====================
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    
    // Get image to delete file
    $select_query = "SELECT image FROM home_coordinators WHERE id = '$delete_id'";
    $result = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row['image']) && file_exists($row['image'])) {
            unlink($row['image']);
        }
    }
    
    $delete_query = "DELETE FROM home_coordinators WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: ad_home_coordinator.php");
        exit();
    } else {
        echo "<script>alert('Error deleting coordinator: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== FETCH ALL COORDINATORS ====================
$coordinatorsData = [];
$select_query = "SELECT * FROM home_coordinators ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $coordinatorsData[] = $row;
    }
}
?>