<?php
// ad_co_announcements_handler.php
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

// ==================== CREATE ANNOUNCEMENTS TABLE ====================
$announcements_table = "CREATE TABLE IF NOT EXISTS announcements (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    emails TEXT NOT NULL,
    content TEXT NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

if (mysqli_query($con, $announcements_table)) {
    // Table created successfully or already exists
} else {
    // echo "Table creation error: " . mysqli_error($con);
}

// ==================== HANDLE ANNOUNCEMENT FORM SUBMISSION ====================
if (isset($_POST['submit_announcement'])) {

    // Get form data
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $emails = mysqli_real_escape_string($con, $_POST['emails']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    // Check if editing or adding
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing announcement
        $edit_id = mysqli_real_escape_string($con, $_POST['edit_id']);

        $update_query = "UPDATE announcements SET 
                        title = '$title',
                        emails = '$emails',
                        content = '$content',
                        status = '$status'
                        WHERE id = '$edit_id'";

        if (mysqli_query($con, $update_query)) {
            echo "<script>alert('Announcement updated successfully!'); window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating announcement: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new announcement with default status 'Active' if not set
        $insert_query = "INSERT INTO announcements (title, emails, content, status) 
                         VALUES ('$title', '$emails', '$content', '$status')";

        if (mysqli_query($con, $insert_query)) {
            echo "<script>alert('Announcement added successfully!'); window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

// ==================== HANDLE STATUS TOGGLE FOR ANNOUNCEMENTS ====================
if (isset($_GET['toggle_announcement_id'])) {
    $toggle_id = mysqli_real_escape_string($con, $_GET['toggle_announcement_id']);

    $toggle_query = "UPDATE announcements SET status = IF(status = 'Active', 'Inactive', 'Active') WHERE id = '$toggle_id'";
    if (mysqli_query($con, $toggle_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error toggling status: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== HANDLE DELETE REQUESTS FOR ANNOUNCEMENTS ====================
if (isset($_GET['delete_announcement_id'])) {
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_announcement_id']);

    $delete_query = "DELETE FROM announcements WHERE id = '$delete_id'";
    if (mysqli_query($con, $delete_query)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Error deleting announcement: " . mysqli_error($con) . "');</script>";
    }
}

// ==================== FETCH ALL ANNOUNCEMENTS ====================
$announcements = [];
$select_query = "SELECT id, title, emails, content, status FROM announcements";
$result = mysqli_query($con, $select_query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $announcements[] = $row;
    }
}
?>