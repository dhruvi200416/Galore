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

// Create home_events table
$home_events_table = "CREATE TABLE IF NOT EXISTS home_events (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    heading VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    button_link VARCHAR(255) NOT NULL,
    button_text VARCHAR(100) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $home_events_table)) {
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
    $heading = mysqli_real_escape_string($con, $_POST['heading']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $button_link = mysqli_real_escape_string($con, $_POST['btn_link']);
    $button_text = mysqli_real_escape_string($con, $_POST['btn_text']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

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
        // Update existing event
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE home_events SET 
                        heading = '$heading',
                        description = '$description',
                        button_link = '$button_link',
                        button_text = '$button_text',
                        status = '$status'";
        
        // Add image to update if a new one was uploaded
        if ($upload_new_image && !empty($image)) {
            // Get old image to delete
            $old_image_query = "SELECT image FROM home_events WHERE id = '$edit_id'";
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
            header("Location: ad_home_events.php");
            exit();
        } else {
            echo "<script>alert('Error updating event: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new event - image is required for new events
        if (empty($image)) {
            echo "<script>alert('Image is required for new events.');</script>";
        } else {
            $insert_query = "INSERT INTO home_events (image, heading, description, button_link, button_text, status) 
                             VALUES ('$image', '$heading', '$description', '$button_link', '$button_text', '$status')";

            if (mysqli_query($con, $insert_query)) {
                header("Location: ad_home_events.php");
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
    
    $toggle_query = "UPDATE home_events SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: ad_home_events.php");
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== HANDLE DELETE REQUEST ====================
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    
    // Get image to delete file
    $select_query = "SELECT image FROM home_events WHERE id = '$delete_id'";
    $result = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row['image']) && file_exists($row['image'])) {
            unlink($row['image']);
        }
    }
    
    $delete_query = "DELETE FROM home_events WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: ad_home_events.php");
        exit();
    } else {
        echo "<script>alert('Error deleting event: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== FETCH ALL EVENTS ====================
$userData = [];
$select_query = "SELECT * FROM home_events ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userData[] = $row;
    }
}

// Close database connection
// mysqli_close($con);
?>