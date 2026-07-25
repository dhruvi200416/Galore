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

// Create carousel_slide table
$carousel_table = "CREATE TABLE IF NOT EXISTS carousel_slide (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) DEFAULT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Inactive',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $carousel_table)) {
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
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $alt_text = mysqli_real_escape_string($con, $title); // Use title as alt text

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
        // Update existing slide
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE carousel_slide SET 
                        title = '$title',
                        alt_text = '$alt_text'";
        
        // Add image to update if a new one was uploaded
        if ($upload_new_image && !empty($image)) {
            // Get old image to delete
            $old_image_query = "SELECT image FROM carousel_slide WHERE id = '$edit_id'";
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
            header("Location: ad_carousel_slide.php");
            exit();
        } else {
            echo "<script>alert('Error updating slide: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new slide - image is required for new slides
        if (empty($image)) {
            echo "<script>alert('Image is required for new slides.');</script>";
        } else {
            $status = 'Inactive'; // Default status for new slides
            $insert_query = "INSERT INTO carousel_slide (image, title, alt_text, status) 
                             VALUES ('$image', '$title', '$alt_text', '$status')";

            if (mysqli_query($con, $insert_query)) {
                header("Location: ad_carousel_slide.php");
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
    
    $toggle_query = "UPDATE carousel_slide SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: ad_carousel_slide.php");
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== HANDLE DELETE REQUEST ====================
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_id']);
    
    // Get image to delete file
    $select_query = "SELECT image FROM carousel_slide WHERE id = '$delete_id'";
    $result = mysqli_query($con, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (!empty($row['image']) && file_exists($row['image'])) {
            unlink($row['image']);
        }
    }
    
    $delete_query = "DELETE FROM carousel_slide WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: ad_carousel_slide.php");
        exit();
    } else {
        echo "<script>alert('Error deleting slide: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== FETCH ALL SLIDES ====================
$slides = [];
$select_query = "SELECT * FROM carousel_slide ORDER BY id ASC";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $slides[] = $row;
    }
}

// Close database connection
// mysqli_close($con);
?>